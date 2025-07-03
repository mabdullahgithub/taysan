<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function view()
    {
        return view('web.chatbot');
    }

    public function getRecommendations(Request $request)
    {
        try {
            $userSkinInfo = $request->input('skin_info');
            $conversationHistory = $request->input('conversation_history', []);
            
            // Check if user is specifically asking for product recommendations
            $isRequestingProducts = $this->isRequestingProductRecommendations($userSkinInfo);
            
            $products = Product::with('category')
                ->where('status', 'active')
                ->where('stock', '>', 0)
                ->get();
            
            // Create product context for AI (only if requesting products)
            $productContext = $isRequestingProducts ? $this->buildProductContext($products) : '';
            
            // Add conversation context for better continuity
            $contextualPrompt = $this->buildContextualPrompt($userSkinInfo, $conversationHistory, $isRequestingProducts);
            
            // Call OpenAI API for conversational response
            $recommendations = $this->callOpenAI($contextualPrompt, $productContext, $isRequestingProducts);
            
            // Get recommended products only if specifically requested
            $recommendedProducts = $isRequestingProducts ? 
                $this->extractRecommendedProducts($recommendations, $products) : [];
            
            return response()->json([
                'success' => true,
                'recommendations' => $recommendations,
                'products' => $recommendedProducts,
                'needs_more_info' => false
            ]);
            
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'I apologize, but I\'m experiencing technical difficulties. Please try again in a moment.'
            ], 500);
        }
    }
    
    private function buildContextualPrompt($userSkinInfo, $conversationHistory, $isRequestingProducts)
    {
        $contextualPrompt = $userSkinInfo;
        
        // Add conversation context if available
        if (!empty($conversationHistory) && count($conversationHistory) > 0) {
            $contextualPrompt = "CONVERSATION CONTEXT:\n";
            
            // Add last 3 exchanges for context
            $recentHistory = array_slice($conversationHistory, -6); // Last 3 user + 3 bot messages
            
            foreach ($recentHistory as $index => $message) {
                $speaker = $index % 2 === 0 ? 'Patient' : 'Dr. AI';
                $contextualPrompt .= "{$speaker}: {$message}\n";
            }
            
            $contextualPrompt .= "\nCURRENT INQUIRY:\n{$userSkinInfo}\n";
            $contextualPrompt .= "\nPlease respond considering the conversation context above.";
        }
        
        return $contextualPrompt;
    }
    
    private function isRequestingProductRecommendations($userInput)
    {
        $input = strtolower(trim($userInput));
        
        // Keywords that indicate user wants product recommendations
        $productRequestKeywords = [
            'recommend', 'suggest', 'product', 'what should i use', 'what can i use',
            'which product', 'show me', 'i need', 'i want to buy', 'help me choose',
            'best product', 'suitable product', 'what product', 'give me',
            'recommend me', 'suggest me', 'show products', 'taysan products'
        ];
        
        foreach ($productRequestKeywords as $keyword) {
            if (strpos($input, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    // Function removed - now using conversational approach instead
    
    private function buildProductContext($products)
    {
        $context = "TAYSAN BEAUTY PRODUCT CATALOG:\n\n";
        
        foreach ($products as $product) {
            $context .= "=== PRODUCT: {$product->name} ===\n";
            $context .= "Category: {$product->category->name}\n";
            $context .= "Price: PKR {$product->price}\n";
            
            if ($product->sale_price && $product->is_on_sale) {
                $context .= "Sale Price: PKR {$product->sale_price} (CURRENTLY ON SALE)\n";
            }
            
            if ($product->description) {
                $context .= "Description: {$product->description}\n";
            }
            
            if ($product->ingredients) {
                $context .= "Key Ingredients: {$product->ingredients}\n";
            }
            
            if ($product->benefits) {
                $context .= "Benefits & Effects: {$product->benefits}\n";
            }
            
            if ($product->usage_instructions) {
                $context .= "How to Use: {$product->usage_instructions}\n";
            }
            
            // Enhanced product attributes
            $attributes = [];
            if ($product->is_organic) $attributes[] = "100% Organic";
            if ($product->is_vegan) $attributes[] = "Vegan-Friendly";
            if ($product->is_cruelty_free) $attributes[] = "Cruelty-Free";
            
            if (!empty($attributes)) {
                $context .= "Special Attributes: " . implode(", ", $attributes) . "\n";
            }
            
            // Add skin type recommendations based on product data
            $context .= "Best For: ";
            if (stripos($product->name . ' ' . $product->description . ' ' . $product->benefits, 'oily') !== false ||
                stripos($product->name . ' ' . $product->description . ' ' . $product->benefits, 'acne') !== false) {
                $context .= "Oily skin, Acne-prone skin, ";
            }
            if (stripos($product->name . ' ' . $product->description . ' ' . $product->benefits, 'dry') !== false ||
                stripos($product->name . ' ' . $product->description . ' ' . $product->benefits, 'hydrat') !== false) {
                $context .= "Dry skin, Dehydrated skin, ";
            }
            if (stripos($product->name . ' ' . $product->description . ' ' . $product->benefits, 'sensitive') !== false ||
                $product->is_organic) {
                $context .= "Sensitive skin, ";
            }
            if (stripos($product->name . ' ' . $product->description . ' ' . $product->benefits, 'aging') !== false ||
                stripos($product->name . ' ' . $product->description . ' ' . $product->benefits, 'wrinkle') !== false) {
                $context .= "Mature skin, Anti-aging, ";
            }
            if (stripos($product->name . ' ' . $product->description . ' ' . $product->benefits, 'bright') !== false ||
                stripos($product->name . ' ' . $product->description . ' ' . $product->benefits, 'spot') !== false) {
                $context .= "Dark spots, Uneven skin tone, ";
            }
            $context .= "All skin types\n";
            
            $context .= "Stock Available: {$product->stock} units\n";
            $context .= "---\n\n";
        }
        
        return $context;
    }
    
    private function callOpenAI($skinInfo, $productContext, $isRequestingProducts = false)
    {
        $apiKey = env('OPENAI_API_KEY');
        
        if (!$apiKey) {
            // Fallback response when no API key
            return $this->getFallbackResponse($skinInfo, $isRequestingProducts);
        }
        
        try {
            if ($isRequestingProducts) {
                // Enhanced product recommendation prompt
                $prompt = "You are Dr. AI, a professional dermatologist and skincare consultant for Taysan Beauty. You specialize in analyzing skin concerns and recommending the most suitable products from our exclusive catalog.

                CUSTOMER CONSULTATION:
                {$skinInfo}

                AVAILABLE TAYSAN BEAUTY PRODUCTS:
                {$productContext}

                INSTRUCTIONS:
                1. Analyze the customer's specific skin type, concerns, age, and current routine
                2. Select ONLY 2-3 products from the Taysan Beauty catalog that best match their needs
                3. For each recommended product, explain:
                   - Why this specific product is perfect for their skin type/concerns
                   - How the ingredients address their specific issues
                   - Expected benefits and results
                4. Provide a brief skincare routine suggestion using these products
                5. IMPORTANT: Only recommend products that are actually listed in the catalog above
                6. Use the exact product names as they appear in the catalog

                Respond as Dr. AI in a professional, caring tone. Keep the response under 350 words but make it comprehensive and personalized.";
            } else {
                // Enhanced conversational prompt
                $prompt = "You are Dr. AI, a board-certified dermatologist and skincare expert with 15+ years of experience. You specialize in:
                - Clinical dermatology and skin health
                - Cosmetic ingredients and formulations
                - Personalized skincare routines
                - Natural and organic skincare solutions
                - Age-appropriate skincare strategies

                PATIENT INQUIRY:
                {$skinInfo}

                GUIDELINES:
                1. Provide evidence-based, professional medical advice
                2. Be conversational but maintain clinical expertise
                3. Explain complex concepts in simple terms
                4. Ask follow-up questions when needed for better assessment
                5. If they need product recommendations, guide them to ask specifically
                6. Focus on education and skin health improvement

                Respond as Dr. AI with warmth and professionalism. Keep responses informative but conversational (under 300 words).";
            }
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o', // Using the latest GPT-4o model for better accuracy
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are Dr. AI, a highly experienced dermatologist and skincare consultant. You provide expert-level advice with clinical precision while maintaining a warm, approachable demeanor. You have deep expertise in ingredient science, skin physiology, and product formulations. Always prioritize skin health and provide personalized recommendations based on individual needs.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => $isRequestingProducts ? 500 : 400,
                'temperature' => 0.3, // Lower temperature for more consistent, accurate responses
                'top_p' => 0.9,
                'frequency_penalty' => 0.2,
                'presence_penalty' => 0.1
            ]);
            
            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'];
            }
            
            // Handle specific API errors
            $error = $response->json();
            if (isset($error['error']['type']) && $error['error']['type'] === 'insufficient_quota') {
                Log::warning('OpenAI quota exceeded, using fallback response');
                return $this->getFallbackResponse($skinInfo, $isRequestingProducts);
            }
            
            throw new \Exception('Failed to get AI recommendations: ' . $response->body());
            
        } catch (\Exception $e) {
            Log::warning('OpenAI API failed, using fallback: ' . $e->getMessage());
            return $this->getFallbackResponse($skinInfo, $isRequestingProducts);
        }
    }
    
    private function getFallbackResponse($skinInfo, $isRequestingProducts = false)
    {
        $skinInfo = strtolower($skinInfo);
        
        if ($isRequestingProducts) {
            // Product recommendation fallbacks
            if (strpos($skinInfo, 'oily') !== false || strpos($skinInfo, 'acne') !== false) {
                return "Thank you for sharing your skin concerns! For oily and acne-prone skin, I recommend looking for products with salicylic acid, tea tree oil, or niacinamide. These ingredients help control excess oil production and reduce breakouts. Our cleansers and toners are specially formulated for this skin type. I'll show you some specific products that would work well for your needs.";
            } elseif (strpos($skinInfo, 'dry') !== false || strpos($skinInfo, 'sensitive') !== false) {
                return "Perfect! For dry and sensitive skin, you'll want products with gentle, hydrating ingredients like hyaluronic acid, ceramides, and natural oils. Avoid harsh chemicals and opt for fragrance-free formulations. Our moisturizers and serums are designed to provide deep hydration while being gentle on sensitive skin. Let me show you some excellent options from our collection.";
            } elseif (strpos($skinInfo, 'aging') !== false || strpos($skinInfo, 'wrinkle') !== false) {
                return "Excellent choice focusing on anti-aging! For mature skin concerns, look for products with retinoids, vitamin C, peptides, and antioxidants. These ingredients help boost collagen production, reduce fine lines, and improve skin texture. Our anti-aging collection includes serums and creams specifically formulated to address these concerns. Here are some powerful products I recommend for you.";
            } elseif (strpos($skinInfo, 'dark spot') !== false || strpos($skinInfo, 'pigment') !== false) {
                return "Great question about dark spots! For hyperpigmentation and uneven skin tone, ingredients like vitamin C, kojic acid, arbutin, and alpha hydroxy acids are your best friends. These help fade existing spots and prevent new ones from forming. Our brightening products are formulated to give you a more even, radiant complexion. Let me show you some targeted solutions.";
            } else {
                return "Thank you for reaching out! Based on your skin concerns, I recommend starting with a gentle cleanser, a good moisturizer, and sunscreen for daily protection. Our product collection includes carefully selected ingredients that work for various skin types. I'll show you some versatile products that would be perfect for building an effective skincare routine tailored to your needs.";
            }
        } else {
            // Conversational fallbacks
            if (strpos($skinInfo, 'hello') !== false || strpos($skinInfo, 'hi') !== false || strpos($skinInfo, 'hey') !== false) {
                return "Hello! I'm Dr. AI, your personal skincare consultant. I'm here to help you with all your skincare questions and concerns. Whether you want to learn about ingredients, discuss skin conditions, or need advice on building a routine, I'm here to help! What would you like to know about skincare today?";
            } elseif (strpos($skinInfo, 'routine') !== false) {
                return "Great question about skincare routines! A good basic routine typically includes: 1) Gentle cleanser (morning and evening), 2) Moisturizer suitable for your skin type, 3) Sunscreen (morning, SPF 30+), and 4) Treatment products as needed (like serums or spot treatments). The key is consistency and using products that work well for your specific skin type. What's your current routine like, or are you just starting out?";
            } elseif (strpos($skinInfo, 'acne') !== false || strpos($skinInfo, 'pimple') !== false) {
                return "I understand how frustrating acne can be! Acne typically develops when pores become clogged with oil, dead skin cells, and bacteria. Key treatment ingredients include salicylic acid (unclogs pores), benzoyl peroxide (kills bacteria), and niacinamide (reduces inflammation). Gentle cleansing, avoiding over-washing, and consistency with treatment are crucial. What type of acne are you dealing with - blackheads, whiteheads, or inflamed pimples?";
            } elseif (strpos($skinInfo, 'dry') !== false || strpos($skinInfo, 'moisture') !== false) {
                return "Dry skin can be quite uncomfortable! It often occurs when your skin barrier is compromised or you're not producing enough natural oils. Look for ingredients like hyaluronic acid (holds moisture), ceramides (repair barrier), and natural oils. Avoid harsh cleansers and over-exfoliating. Humidifiers can also help, especially in dry climates. Is your skin dry all over or just in certain areas?";
            } elseif (strpos($skinInfo, 'sensitive') !== false) {
                return "Sensitive skin requires extra care! It's often reactive to fragrances, harsh chemicals, or environmental factors. Key tips: use fragrance-free products, patch test new items, avoid over-exfoliating, and look for gentle, hypoallergenic formulas. Ingredients like aloe vera, chamomile, and ceramides can be soothing. What triggers seem to irritate your skin the most?";
            } elseif (strpos($skinInfo, 'sunscreen') !== false || strpos($skinInfo, 'spf') !== false) {
                return "Sunscreen is absolutely essential for healthy skin! Use broad-spectrum SPF 30 or higher daily, even indoors (UV rays penetrate windows). Reapply every 2 hours when outside. Chemical sunscreens absorb UV rays, while mineral/physical sunscreens reflect them. For sensitive skin, zinc oxide and titanium dioxide are great options. Do you have trouble finding sunscreens that don't irritate your skin?";
            } elseif (strpos($skinInfo, 'aging') !== false || strpos($skinInfo, 'wrinkle') !== false) {
                return "Anti-aging is all about prevention and treatment! Key strategies include: daily sunscreen (prevents 80% of aging), retinoids (boost collagen), vitamin C (antioxidant protection), and proper hydration. Start slowly with active ingredients to avoid irritation. Remember, consistency is more important than using many products. What specific signs of aging are you most concerned about?";
            } elseif (strpos($skinInfo, 'ingredient') !== false) {
                return "I'd love to help you understand skincare ingredients! There are so many beneficial ones: hyaluronic acid (hydration), niacinamide (oil control), vitamin C (brightening), retinol (anti-aging), salicylic acid (acne), and ceramides (barrier repair). Each serves different purposes. What specific ingredient were you curious about, or would you like recommendations for your skin concerns?";
            } else {
                return "I'm here to help with any skincare questions you have! Whether you're curious about ingredients, skin conditions, routines, or just want general advice, feel free to ask. I can discuss topics like acne treatment, anti-aging, sensitive skin care, product ingredients, and much more. What's on your mind regarding skincare today?";
            }
        }
    }
    
    private function extractRecommendedProducts($aiResponse, $products)
    {
        // Extract product names mentioned in AI response with better matching
        $recommendedProducts = collect();
        
        // First, try to find exact product name matches
        foreach ($products as $product) {
            $productName = $product->name;
            
            // Check for exact name match (case insensitive)
            if (stripos($aiResponse, $productName) !== false) {
                $recommendedProducts->push($this->formatProductData($product, $aiResponse));
                continue;
            }
            
            // Check for partial name matches (for products with long names)
            $nameWords = explode(' ', $productName);
            if (count($nameWords) > 2) {
                $shortName = implode(' ', array_slice($nameWords, 0, 2));
                if (stripos($aiResponse, $shortName) !== false) {
                    $recommendedProducts->push($this->formatProductData($product, $aiResponse));
                    continue;
                }
            }
        }
        
        // If we found specific products, return them (limit to 3)
        if ($recommendedProducts->isNotEmpty()) {
            return $recommendedProducts->take(3);
        }
        
        // If no specific products found, use intelligent matching based on AI analysis
        return $this->getIntelligentProductRecommendations($products, $aiResponse);
    }
    
    private function formatProductData($product, $aiResponse)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image ? asset('storage/' . $product->image) : asset('logo.png'),
            'category' => $product->category->name,
            'description' => $product->description,
            'benefits' => $product->benefits,
            'ingredients' => $product->ingredients,
            'usage_instructions' => $product->usage_instructions,
            'is_organic' => (bool)$product->is_organic,
            'is_vegan' => (bool)$product->is_vegan,
            'is_cruelty_free' => (bool)$product->is_cruelty_free,
            'is_on_sale' => (bool)$product->is_on_sale,
            'sale_price' => $product->sale_price,
            'stock' => $product->stock,
            'recommendation_reason' => $this->getRecommendationReason($aiResponse, $product->name)
        ];
    }
    
    private function getIntelligentProductRecommendations($products, $aiResponse)
    {
        $recommendations = collect();
        $aiResponseLower = strtolower($aiResponse);
        
        // Analyze AI response for skin concerns and match with products
        $skinConcerns = $this->extractSkinConcerns($aiResponseLower);
        $recommendedIngredients = $this->extractRecommendedIngredients($aiResponseLower);
        
        foreach ($products as $product) {
            $score = $this->calculateProductScore($product, $skinConcerns, $recommendedIngredients);
            if ($score > 0) {
                $productData = $this->formatProductData($product, $aiResponse);
                $productData['match_score'] = $score;
                $recommendations->push($productData);
            }
        }
        
        // Sort by match score and return top 3
        return $recommendations->sortByDesc('match_score')->take(3)->values();
    }
    
    private function extractSkinConcerns($aiResponse)
    {
        $concerns = [];
        $concernKeywords = [
            'acne' => ['acne', 'pimple', 'breakout', 'blemish', 'comedone'],
            'oily' => ['oily', 'oil control', 'sebum', 'excess oil'],
            'dry' => ['dry', 'dehydrated', 'moisture', 'hydration'],
            'sensitive' => ['sensitive', 'irritated', 'reactive', 'gentle'],
            'aging' => ['aging', 'wrinkle', 'fine line', 'anti-aging', 'mature'],
            'pigmentation' => ['dark spot', 'pigmentation', 'melasma', 'brightening', 'even tone']
        ];
        
        foreach ($concernKeywords as $concern => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($aiResponse, $keyword) !== false) {
                    $concerns[] = $concern;
                    break;
                }
            }
        }
        
        return array_unique($concerns);
    }
    
    private function extractRecommendedIngredients($aiResponse)
    {
        $ingredients = [];
        $ingredientKeywords = [
            'hyaluronic acid', 'vitamin c', 'retinol', 'niacinamide', 'salicylic acid',
            'glycolic acid', 'kojic acid', 'arbutin', 'peptides', 'ceramides',
            'tea tree', 'aloe vera', 'chamomile', 'green tea', 'rosehip'
        ];
        
        foreach ($ingredientKeywords as $ingredient) {
            if (strpos($aiResponse, $ingredient) !== false) {
                $ingredients[] = $ingredient;
            }
        }
        
        return $ingredients;
    }
    
    private function calculateProductScore($product, $skinConcerns, $recommendedIngredients)
    {
        $score = 0;
        $productText = strtolower($product->name . ' ' . $product->description . ' ' . 
                                 $product->benefits . ' ' . $product->ingredients);
        
        // Score based on skin concerns match
        foreach ($skinConcerns as $concern) {
            if (strpos($productText, $concern) !== false) {
                $score += 10;
            }
        }
        
        // Score based on recommended ingredients
        foreach ($recommendedIngredients as $ingredient) {
            if (strpos($productText, $ingredient) !== false) {
                $score += 5;
            }
        }
        
        // Bonus points for special attributes
        if (in_array('sensitive', $skinConcerns) && $product->is_organic) {
            $score += 3;
        }
        
        return $score;
    }
    
    private function getRecommendationReason($aiResponse, $productName)
    {
        // Extract the sentence that mentions this product for personalized reasoning
        $sentences = explode('.', $aiResponse);
        foreach ($sentences as $sentence) {
            if (stripos($sentence, $productName) !== false) {
                return trim($sentence) . '.';
            }
        }
        return 'Recommended by Dr. AI for your specific skin needs.';
    }
    
    private function getSmartProductRecommendations($products, $skinInfo)
    {
        $recommendations = collect();
        $reasons = [];
        
        if (strpos($skinInfo, 'oily') !== false || strpos($skinInfo, 'acne') !== false) {
            // Find products suitable for oily/acne skin
            $suitableProducts = $products->filter(function ($product) {
                $searchText = strtolower($product->name . ' ' . $product->description . ' ' . $product->benefits . ' ' . $product->ingredients);
                return strpos($searchText, 'oil control') !== false ||
                       strpos($searchText, 'acne') !== false ||
                       strpos($searchText, 'cleanser') !== false ||
                       strpos($searchText, 'toner') !== false ||
                       strpos($searchText, 'salicylic') !== false ||
                       strpos($searchText, 'tea tree') !== false ||
                       strpos($searchText, 'niacinamide') !== false;
            });
            $reasons = [
                'Perfect for controlling excess oil and preventing breakouts',
                'Helps reduce acne and minimize pores',
                'Contains oil-balancing ingredients for clearer skin'
            ];
        } elseif (strpos($skinInfo, 'dry') !== false || strpos($skinInfo, 'sensitive') !== false) {
            // Find products for dry/sensitive skin
            $suitableProducts = $products->filter(function ($product) {
                $searchText = strtolower($product->name . ' ' . $product->description . ' ' . $product->benefits . ' ' . $product->ingredients);
                return strpos($searchText, 'moistur') !== false ||
                       strpos($searchText, 'hydrat') !== false ||
                       strpos($searchText, 'gentle') !== false ||
                       strpos($searchText, 'sensitive') !== false ||
                       strpos($searchText, 'hyaluronic') !== false ||
                       strpos($searchText, 'ceramide') !== false ||
                       $product->is_organic;
            });
            $reasons = [
                'Provides deep hydration for dry skin',
                'Gentle formula perfect for sensitive skin',
                'Nourishes and soothes irritated skin'
            ];
        } elseif (strpos($skinInfo, 'aging') !== false || strpos($skinInfo, 'wrinkle') !== false) {
            // Find anti-aging products
            $suitableProducts = $products->filter(function ($product) {
                $searchText = strtolower($product->name . ' ' . $product->description . ' ' . $product->benefits . ' ' . $product->ingredients);
                return strpos($searchText, 'anti-aging') !== false ||
                       strpos($searchText, 'wrinkle') !== false ||
                       strpos($searchText, 'collagen') !== false ||
                       strpos($searchText, 'vitamin c') !== false ||
                       strpos($searchText, 'retinol') !== false ||
                       strpos($searchText, 'peptide') !== false ||
                       strpos($searchText, 'serum') !== false;
            });
            $reasons = [
                'Helps reduce fine lines and wrinkles',
                'Boosts collagen production for firmer skin',
                'Contains powerful anti-aging ingredients'
            ];
        } elseif (strpos($skinInfo, 'dark spot') !== false || strpos($skinInfo, 'pigment') !== false) {
            // Find brightening products
            $suitableProducts = $products->filter(function ($product) {
                $searchText = strtolower($product->name . ' ' . $product->description . ' ' . $product->benefits . ' ' . $product->ingredients);
                return strpos($searchText, 'brighten') !== false ||
                       strpos($searchText, 'spot') !== false ||
                       strpos($searchText, 'vitamin c') !== false ||
                       strpos($searchText, 'kojic') !== false ||
                       strpos($searchText, 'arbutin') !== false ||
                       strpos($searchText, 'even tone') !== false;
            });
            $reasons = [
                'Helps fade dark spots and hyperpigmentation',
                'Evens out skin tone for a brighter complexion',
                'Contains powerful brightening ingredients'
            ];
        } else {
            // General skincare routine
            $suitableProducts = $products->filter(function ($product) {
                $searchText = strtolower($product->name . ' ' . $product->description);
                return strpos($searchText, 'cleanser') !== false ||
                       strpos($searchText, 'moistur') !== false ||
                       strpos($searchText, 'serum') !== false ||
                       $product->is_organic;
            });
            $reasons = [
                'Essential for a complete skincare routine',
                'Perfect for maintaining healthy skin',
                'Gentle and effective for daily use'
            ];
        }
        
        // If no suitable products found, get any 3 products
        if ($suitableProducts->isEmpty()) {
            $suitableProducts = $products->take(3);
            $reasons = [
                'Highly recommended by Dr. AI',
                'Popular choice among our customers',
                'Quality product for healthy skin'
            ];
        }
        
        // Get up to 3 products with reasons
        $selectedProducts = $suitableProducts->take(3);
        foreach ($selectedProducts as $index => $product) {
            $recommendations->push([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image ? asset('storage/' . $product->image) : asset('logo.png'),
                'category' => $product->category->name,
                'description' => $product->description,
                'benefits' => $product->benefits,
                'ingredients' => $product->ingredients,
                'is_organic' => (bool)$product->is_organic,
                'is_vegan' => (bool)$product->is_vegan,
                'is_cruelty_free' => (bool)$product->is_cruelty_free,
                'is_on_sale' => (bool)$product->is_on_sale,
                'sale_price' => $product->sale_price,
                'recommendation_reason' => $reasons[$index] ?? $reasons[0]
            ]);
        }
        
        return $recommendations;
    }
}
