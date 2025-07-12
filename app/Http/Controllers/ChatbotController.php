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
            
            // Create product context for AI
            $productContext = $this->buildProductContext($products);
            
            // Add conversation context for better continuity
            $contextualPrompt = $this->buildContextualPrompt($userSkinInfo, $conversationHistory, $isRequestingProducts);
            
            // Call OpenAI API for conversational response
            $recommendations = $this->callOpenAI($contextualPrompt, $productContext, $isRequestingProducts);
            
            // Always try to get recommended products based on skin analysis
            $recommendedProducts = $this->extractRecommendedProducts($recommendations, $products);
            
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
                // Enhanced product recommendation prompt with new styling guidance
                $prompt = "You are Dr. AI, a professional skincare specialist for Taysan Beauty with expertise in dermatology. You help customers find the perfect skincare products for their specific needs.

                CUSTOMER CONSULTATION:
                {$skinInfo}

                AVAILABLE TAYSAN BEAUTY PRODUCTS:
                {$productContext}

                INSTRUCTIONS:
                1. Analyze the customer's skin type, concerns, age, and current routine
                2. Select ONLY 2-3 products from the Taysan Beauty catalog that best match their needs
                3. For each recommended product, provide a brief explanation (1-2 sentences) on why it's suitable
                4. CRITICAL: Keep your response very short and concise (maximum 200 words)
                5. Use simple, clear language that's easy to understand
                6. Only recommend products that are actually listed in the catalog
                7. Use the exact product names as they appear in the catalog
                
                IMPORTANT STYLE REQUIREMENTS:
                - Be friendly but professional
                - Avoid lengthy explanations
                - Use short sentences and paragraphs
                - Focus only on skin and health care topics
                - After your answer, always suggest they try the recommended products

                Remember: Your goal is to provide quick, accurate product recommendations that solve the customer's skincare concerns.";
            } else {
                // Enhanced conversational prompt with new styling guidance
                $prompt = "You are Dr. AI, a skincare specialist at Taysan Beauty. You provide expert advice on skin health, skincare ingredients, and routines.

                CUSTOMER INQUIRY:
                {$skinInfo}

                INSTRUCTIONS:
                1. ONLY answer questions related to skin care, skincare products, skin health, or beauty routines
                2. If the question is not related to these topics, politely explain you can only help with skincare concerns
                3. Keep your response extremely concise (maximum 150 words)
                4. Use simple, everyday language - avoid technical terms when possible
                5. Be friendly but professional
                6. Focus on providing practical, actionable advice
                7. If they ask about non-skincare health issues, suggest they consult a medical professional
                
                CRITICAL REQUIREMENTS:
                - Never provide medical diagnoses or treatment advice for serious conditions
                - Always clarify you are a skincare advisor, not a medical doctor
                - Keep paragraphs to 2-3 sentences maximum
                - After your answer, always ask if they'd like product suggestions for their concerns

                Remember: Your goal is to provide quick, clear skincare advice and guide customers toward appropriate Taysan Beauty products when relevant.";
            }
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o', // Using the latest GPT-4o model for better accuracy
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are Dr. AI, a friendly skincare specialist at Taysan Beauty. You provide short, clear advice on skincare concerns and product recommendations. You ONLY answer questions related to skin care, skin health, beauty routines, and skincare products. For any other topics, politely explain you can only help with skincare concerns. Your responses are concise, practical, and focused on guiding customers to the right skincare solutions.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => $isRequestingProducts ? 300 : 200, // Reduced token limit for shorter responses
                'temperature' => 0.3, // Lower temperature for more consistent, accurate responses
                'top_p' => 0.9,
                'frequency_penalty' => 0.2,
                'presence_penalty' => 0.1
            ]);
            
            if ($response->successful()) {
                $aiResponse = $response->json()['choices'][0]['message']['content'];
                
                // Check if this is not a product recommendation and the question is not skin-related
                if (!$isRequestingProducts && !$this->isSkinCareRelated($skinInfo)) {
                    return "I'm a skincare specialist and can only answer questions related to skin care, skincare products, and beauty routines. If you have any questions about your skin concerns or would like product recommendations, I'd be happy to help with those!";
                }
                
                // For product recommendations, always append product suggestion prompt
                if (!$isRequestingProducts) {
                    // Product suggestion button will be added via JavaScript
                    // No text suggestion needed anymore
                }
                
                return $aiResponse;
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
    
    private function isSkinCareRelated($userInput) {
        $input = strtolower(trim($userInput));
        
        $skinCareKeywords = [
            'skin', 'acne', 'pimple', 'breakout', 'wrinkle', 'anti-aging', 'dry', 'oily', 
            'moisturizer', 'serum', 'cleanser', 'toner', 'exfoliat', 'spf', 'sunscreen', 
            'dark spot', 'pigment', 'sensitive', 'redness', 'routine', 'face', 'cream',
            'lotion', 'skincare', 'beauty', 'ingredient', 'product', 'hyaluronic', 'vitamin c',
            'retinol', 'salicylic', 'glycolic', 'acid', 'hydration', 'moistur', 'pore',
            'blackhead', 'whitehead', 'mask', 'facial', 'treatment', 'night cream', 'day cream',
            'eye cream', 'lip', 'oil', 'natural', 'organic', 'chemical', 'physical', 'sunburn',
            'scar', 'mark', 'complexion', 'tone', 'texture', 'dermatitis', 'eczema', 'psoriasis',
            'rosacea', 'soap', 'wash', 'cleanse', 'vitamin a', 'niacinamide', 'peptide',
            'collagen', 'elastin', 'uv', 'sun damage', 'glow', 'radiant', 'dull', 'brightening',
            'lightening', 'scrub', 'peel', 'allergen', 'irritation', 'patch test', 'dermis',
            'epidermis', 'sebum', 'hydrate', 'dehydrate', 'makeup'
        ];
        
        foreach ($skinCareKeywords as $keyword) {
            if (strpos($input, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }
    
    private function getFallbackResponse($skinInfo, $isRequestingProducts = false)
    {
        $skinInfo = strtolower($skinInfo);
        
        if ($isRequestingProducts) {
            // Product recommendation fallbacks - shorter and more concise
            if (strpos($skinInfo, 'oily') !== false || strpos($skinInfo, 'acne') !== false) {
                return "For oily and acne-prone skin, I recommend products with salicylic acid, tea tree oil, or niacinamide. These ingredients control excess oil and reduce breakouts. Our cleansers and toners are perfect for this skin type. Here are some specific products that would work well for you:";
            } elseif (strpos($skinInfo, 'dry') !== false || strpos($skinInfo, 'sensitive') !== false) {
                return "For dry and sensitive skin, look for gentle, hydrating ingredients like hyaluronic acid, ceramides, and natural oils. Our moisturizers and serums provide deep hydration while being gentle on sensitive skin. Here are some excellent options from our collection:";
            } elseif (strpos($skinInfo, 'aging') !== false || strpos($skinInfo, 'wrinkle') !== false) {
                return "For anti-aging concerns, products with retinoids, vitamin C, peptides, and antioxidants are ideal. These boost collagen, reduce fine lines, and improve texture. Here are some effective anti-aging products I recommend:";
            } elseif (strpos($skinInfo, 'dark spot') !== false || strpos($skinInfo, 'pigment') !== false) {
                return "For hyperpigmentation and uneven tone, look for vitamin C, kojic acid, arbutin, and alpha hydroxy acids. These fade existing spots and prevent new ones. Here are some targeted brightening solutions:";
            } else {
                return "Based on your concerns, I recommend a gentle cleanser, moisturizer, and daily sunscreen. Here are some versatile products that would work well for your skincare needs:";
            }
        } else {
            // Conversational fallbacks - shorter with product suggestion prompt
            $productPrompt = "\n\nWould you like me to suggest some products that might help with your skin concerns?";
            
            if (strpos($skinInfo, 'hello') !== false || strpos($skinInfo, 'hi') !== false || strpos($skinInfo, 'hey') !== false) {
                return "Hello! I'm Dr. AI, your skincare specialist. I can help with skincare questions, ingredients, and product recommendations. What skincare concerns can I help you with today?" . $productPrompt;
            } elseif (strpos($skinInfo, 'routine') !== false) {
                return "A good skincare routine includes: 1) Gentle cleanser, 2) Moisturizer for your skin type, 3) SPF 30+ sunscreen, and 4) Targeted treatments as needed. Consistency is key! What's your current routine like?" . $productPrompt;
            } elseif (strpos($skinInfo, 'acne') !== false || strpos($skinInfo, 'pimple') !== false) {
                return "For acne, look for products with salicylic acid (unclogs pores), benzoyl peroxide (kills bacteria), or niacinamide (reduces inflammation). Gentle cleansing and consistency are essential. What type of acne are you experiencing?" . $productPrompt;
            } elseif (strpos($skinInfo, 'dry') !== false || strpos($skinInfo, 'moisture') !== false) {
                return "For dry skin, use products with hyaluronic acid, ceramides, and natural oils. Avoid harsh cleansers and over-exfoliating. Is your skin dry all over or just in certain areas?" . $productPrompt;
            } elseif (strpos($skinInfo, 'sensitive') !== false) {
                return "For sensitive skin, use fragrance-free, gentle products. Patch test new items and avoid over-exfoliating. Ingredients like aloe vera, chamomile, and ceramides are soothing. What seems to trigger your skin sensitivity?" . $productPrompt;
            } elseif (strpos($skinInfo, 'sunscreen') !== false || strpos($skinInfo, 'spf') !== false) {
                return "Use broad-spectrum SPF 30+ daily, even indoors. Reapply every 2 hours when outside. For sensitive skin, try mineral sunscreens with zinc oxide or titanium dioxide. Do you prefer chemical or physical sunscreens?" . $productPrompt;
            } elseif (strpos($skinInfo, 'aging') !== false || strpos($skinInfo, 'wrinkle') !== false) {
                return "For anti-aging: 1) Use daily sunscreen, 2) Add retinoids to boost collagen, 3) Use vitamin C for antioxidant protection, and 4) Keep skin hydrated. Start slowly with active ingredients. What specific aging concerns do you have?" . $productPrompt;
            } elseif (strpos($skinInfo, 'ingredient') !== false) {
                return "Key ingredients include: hyaluronic acid (hydration), niacinamide (oil control), vitamin C (brightening), retinol (anti-aging), and salicylic acid (acne). Which specific ingredients are you curious about?" . $productPrompt;
            } else {
                return "I'm happy to help with any skincare questions! I can discuss ingredients, routines, specific concerns, or product recommendations. What would you like to know about your skin?" . $productPrompt;
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
        
        // If no direct mention, create specific reasons based on product name and type
        $productNameLower = strtolower($productName);
        $aiResponseLower = strtolower($aiResponse);
        
        // Check for specific skin concerns mentioned in the AI response
        if (strpos($aiResponseLower, 'acne') !== false || strpos($aiResponseLower, 'pimple') !== false || strpos($aiResponseLower, 'breakout') !== false) {
            return "Contains active ingredients to target acne, reduce inflammation, and prevent new breakouts while supporting your skin's healing process.";
        } 
        
        if (strpos($aiResponseLower, 'oily') !== false) {
            return "Formulated to balance oil production, minimize shine, and reduce pore appearance without over-drying your skin.";
        }
        
        if (strpos($aiResponseLower, 'dry') !== false || strpos($aiResponseLower, 'dehydrat') !== false) {
            return "Rich in hydrating ingredients that restore moisture barrier, relieve tightness, and provide long-lasting hydration for your dry skin.";
        }
        
        if (strpos($aiResponseLower, 'sensitive') !== false || strpos($aiResponseLower, 'irritat') !== false) {
            return "Specially formulated with gentle, soothing ingredients to calm irritation and strengthen your sensitive skin's natural defenses.";
        }
        
        if (strpos($aiResponseLower, 'aging') !== false || strpos($aiResponseLower, 'wrinkle') !== false || strpos($aiResponseLower, 'fine line') !== false) {
            return "Contains powerful anti-aging actives that boost collagen production, improve elasticity, and visibly reduce the appearance of fine lines and wrinkles.";
        }
        
        return 'Specifically selected for your skin concerns with clinically-proven ingredients to improve your skin\'s health and appearance.';
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
