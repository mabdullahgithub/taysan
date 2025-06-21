@php
    $logo = \App\Models\Setting::get('logo');
    $logoUrl = $logo ? asset('storage/' . $logo) : asset('logo.png');
    $companyDescription = \App\Models\Setting::get('footer_company_description', 'Your trusted destination for natural beauty products. We specialize in handcrafted soaps and organic skincare made with love and pure ingredients.');
    $founderName = \App\Models\Setting::get('footer_founder_name', 'Muhammad Abdullah');
    $founderTitle = \App\Models\Setting::get('footer_founder_title', 'Founder & CEO');
    $address = \App\Models\Setting::get('footer_address', 'Lahore, Pakistan');
    $phone = \App\Models\Setting::get('footer_phone', '+92 311 5904288');
    $whatsapp = \App\Models\Setting::get('footer_whatsapp', 'https://wa.me/923115904288');
    $email = \App\Models\Setting::get('footer_email', 'info@taysan.co');
    $facebook = \App\Models\Setting::get('footer_facebook', '#');
    $instagram = \App\Models\Setting::get('footer_instagram', '#');
    $twitter = \App\Models\Setting::get('footer_twitter', '#');
    $copyright = \App\Models\Setting::get('footer_copyright', 'Copyright © 2025 by Taysan Beauty. All Rights Reserved. | Founded by Muhammad Abdullah');
@endphp

<footer style="background-color: #f8f9fa !important; padding: 60px 0 0 !important; margin-top: 60px !important; border-top: 1px solid #eee !important; width: 100% !important; position: relative !important; left: 0 !important; right: 0 !important;">
    <div class="container" style="max-width: 1200px !important; margin-left: auto !important; margin-right: auto !important; padding-left: 15px !important; padding-right: 15px !important; width: 100% !important;">
        <div class="row gy-4" style="display: flex !important; flex-wrap: wrap !important; margin-right: -15px !important; margin-left: -15px !important;">
            <!-- Company Info -->
            <div class="col-lg-4 col-md-12" style="padding: 0 15px !important;">
                <div style="max-width: 400px !important;">
                    <img src="{{ $logoUrl }}" alt="logo" style="height: 40px !important; width: auto !important; margin-bottom: 20px !important; display: block !important;">
                    <p style="color: #666 !important; line-height: 1.6 !important; margin-bottom: 20px !important; font-size: 14px !important;">
                        {{ $companyDescription }}
                    </p>
                    <div class="d-flex gap-3" style="display: flex !important; gap: 15px !important;">
                        <a href="{{ $facebook }}" class="d-flex align-items-center justify-content-center" 
                           style="width: 36px !important; height: 36px !important; border-radius: 50% !important; background-color: #8D68AD !important; color: white !important; text-decoration: none !important; transition: all 0.3s !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                            <i class="fab fa-facebook-f" style="font-size: 14px !important;"></i>
                        </a>
                        <a href="{{ $instagram }}" class="d-flex align-items-center justify-content-center" 
                           style="width: 36px !important; height: 36px !important; border-radius: 50% !important; background-color: #8D68AD !important; color: white !important; text-decoration: none !important; transition: all 0.3s !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                            <i class="fab fa-instagram" style="font-size: 14px !important;"></i>
                        </a>
                        <a href="{{ $twitter }}" class="d-flex align-items-center justify-content-center" 
                           style="width: 36px !important; height: 36px !important; border-radius: 50% !important; background-color: #8D68AD !important; color: white !important; text-decoration: none !important; transition: all 0.3s !important; display: flex !important; align-items: center !important; justify-content: center !important;">
                            <i class="fab fa-twitter" style="font-size: 14px !important;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-4 col-md-6" style="padding: 0 15px !important;">
                <h3 style="color: #333 !important; font-size: 1.25rem !important; margin-bottom: 20px !important; font-weight: 600 !important;">Quick Links</h3>
                <ul class="list-unstyled" style="margin: 0 !important; padding: 0 !important; list-style: none !important;">
                    <li class="mb-2" style="margin-bottom: 10px !important;">
                        <a href="/" style="color: #666 !important; text-decoration: none !important; transition: color 0.3s !important; display: block !important;" 
                           onmouseover="this.style.color='#8D68AD !important'" 
                           onmouseout="this.style.color='#666 !important'">Home</a>
                    </li>
                    <li class="mb-2" style="margin-bottom: 10px !important;">
                        <a href="/shop" style="color: #666 !important; text-decoration: none !important; transition: color 0.3s !important; display: block !important;"
                           onmouseover="this.style.color='#8D68AD !important'" 
                           onmouseout="this.style.color='#666 !important'">Shop</a>
                    </li>
                    <li class="mb-2" style="margin-bottom: 10px !important;">
                        <a href="/about" style="color: #666 !important; text-decoration: none !important; transition: color 0.3s !important; display: block !important;"
                           onmouseover="this.style.color='#8D68AD !important'" 
                           onmouseout="this.style.color='#666 !important'">About Us</a>
                    </li>
                    <li class="mb-2" style="margin-bottom: 10px !important;">
                        <a href="/contact" style="color: #666 !important; text-decoration: none !important; transition: color 0.3s !important; display: block !important;"
                           onmouseover="this.style.color='#8D68AD !important'" 
                           onmouseout="this.style.color='#666 !important'">Contact Us</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-4 col-md-6" style="padding: 0 15px !important;">
                <h3 style="color: #333 !important; font-size: 1.25rem !important; margin-bottom: 20px !important; font-weight: 600 !important;">Contact Us</h3>
                <ul class="list-unstyled" style="margin: 0 !important; padding: 0 !important; list-style: none !important;">
                    <li class="d-flex gap-3 mb-3" style="display: flex !important; gap: 15px !important; margin-bottom: 15px !important; color: #666 !important;">
                        <i class="fas fa-user" style="color: #8D68AD !important; margin-top: 4px !important;"></i>
                        <span><strong>{{ $founderName }}</strong><br><small>{{ $founderTitle }}</small></span>
                    </li>
                    <li class="d-flex gap-3 mb-3" style="display: flex !important; gap: 15px !important; margin-bottom: 15px !important; color: #666 !important;">
                        <i class="fas fa-map-marker-alt" style="color: #8D68AD !important; margin-top: 4px !important;"></i>
                        <span>{{ $address }}</span>
                    </li>
                    <li class="d-flex gap-3 mb-3" style="display: flex !important; gap: 15px !important; margin-bottom: 15px !important;">
                        <i class="fab fa-whatsapp" style="color: #8D68AD !important; margin-top: 4px !important;"></i>
                        <a href="{{ $whatsapp }}" style="color: #666 !important; text-decoration: none !important; transition: color 0.3s !important;"
                           onmouseover="this.style.color='#8D68AD !important'" 
                           onmouseout="this.style.color='#666 !important'">{{ $phone }}</a>
                    </li>
                    <li class="d-flex gap-3 mb-3" style="display: flex !important; gap: 15px !important; margin-bottom: 15px !important;">
                        <i class="fas fa-envelope" style="color: #8D68AD !important; margin-top: 4px !important;"></i>
                        <a href="mailto:{{ $email }}" style="color: #666 !important; text-decoration: none !important; transition: color 0.3s !important;"
                           onmouseover="this.style.color='#8D68AD !important'" 
                           onmouseout="this.style.color='#666 !important'">{{ $email }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div style="background-color: white !important; padding: 20px 0 !important; margin-top: 40px !important; border-top: 1px solid #eee !important; width: 100% !important;">
        <div class="container" style="max-width: 1200px !important; margin-left: auto !important; margin-right: auto !important;">
            <p class="text-center mb-0" style="text-align: center !important; margin-bottom: 0 !important; color: #666 !important;">
                {{ $copyright }}
            </p>
        </div>
    </div>
</footer>