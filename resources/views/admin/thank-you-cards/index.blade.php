@extends('admin.layout.app')
@section('title', 'Thank You Cards')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap');
    
    :root {
        --primary-color: #8B7BA8;
        --primary-light: #A893C4;
        --primary-dark: #6B5B7D;
        --text-dark: #2D3748;
        --text-medium: #4A5568;
        --text-light: #718096;
        --border-light: #E2E8F0;
        --background: #F8F9FA;
        --white: #FFFFFF;
        --shadow: 0 4px 16px rgba(0,0,0,0.1);
        --shadow-hover: 0 8px 32px rgba(0,0,0,0.15);
    }

    .cards-container {
        background: var(--background);
        min-height: 100vh;
        padding: 2rem;
        font-family: 'Poppins', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 20px;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    .page-title {
        font-family: 'Comfortaa', cursive;
        font-size: 3rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        position: relative;
        z-index: 2;
    }

    .page-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        position: relative;
        z-index: 2;
    }

    .action-section {
        background: var(--white);
        border-radius: 20px;
        padding: 3rem 2rem;
        box-shadow: var(--shadow);
        text-align: center;
        margin-bottom: 2rem;
    }

    .action-title {
        font-family: 'Comfortaa', cursive;
        font-size: 2rem;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .action-subtitle {
        color: var(--text-medium);
        font-size: 1.1rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        color: white;
        box-shadow: 0 4px 15px rgba(139, 123, 168, 0.4);
        font-size: 1.2rem;
        padding: 1.25rem 2.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(139, 123, 168, 0.5);
    }

    .btn-secondary {
        background: var(--white);
        color: var(--text-dark);
        border: 2px solid var(--border-light);
    }

    .btn-secondary:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .cards-container {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 2.5rem;
        }
        
        .btn-primary {
            font-size: 1.1rem;
            padding: 1rem 2rem;
        }
    }
</style>

<div class="cards-container">
    <!-- Page Header -->
    {{-- <div class="page-header">
        <h1 class="page-title">🎨 Thank You Cards Studio</h1>
        <p class="page-subtitle">Create beautiful, personalized cards for your customers with stunning designs and modern aesthetics</p>
    </div> --}}

    <!-- Main Action Section -->
    <div class="action-section">
        <h2 class="action-title">🎨 Ready to Create Something Beautiful?</h2>
        <p class="action-subtitle">Start designing your perfect customer card with our intuitive creator. Choose from modern styles, vibrant colors, and upload your own images to make each card unique and memorable.</p>
        
        <a href="{{ route('admin.thank-you-cards.create') }}" class="btn btn-primary">
            <i class="fas fa-magic"></i>
            Create New Card
        </a>
        
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back to Dashboard
        </a>
    </div>
</div>

@endsection
