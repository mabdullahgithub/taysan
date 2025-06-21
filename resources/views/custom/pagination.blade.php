@if ($paginator->hasPages())
    <div class="modern-pagination-container">
        <nav class="modern-pagination" role="navigation" aria-label="Pagination Navigation">
            <div class="pagination-nav">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="pagination-btn pagination-btn-disabled">
                        <i class="fas fa-chevron-left"></i>
                        <span class="btn-text">Previous</span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn pagination-btn-primary" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                        <span class="btn-text">Previous</span>
                    </a>
                @endif

                {{-- Page Numbers --}}
                <div class="page-numbers">
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="page-dots">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="page-number page-number-active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="page-number">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </div>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn pagination-btn-primary" rel="next">
                        <span class="btn-text">Next</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="pagination-btn pagination-btn-disabled">
                        <span class="btn-text">Next</span>
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </nav>
    </div>

    <style>
        .modern-pagination-container {
            margin: 2rem 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modern-pagination {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .pagination-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #FFFFFF;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #E2E8F0;
        }

        .pagination-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .pagination-btn-primary {
            color: #8B7BA8;
            background: #F7F5FA;
            border: 1px solid #E9E3F0;
        }

        .pagination-btn-primary:hover {
            color: #FFFFFF;
            background: #8B7BA8;
            border-color: #8B7BA8;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(139, 123, 168, 0.2);
        }

        .pagination-btn-disabled {
            color: #A0AEC0;
            background: #F7FAFC;
            border: 1px solid #E2E8F0;
            cursor: not-allowed;
        }

        .page-numbers {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin: 0 1rem;
        }

        .page-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            color: #4A5568;
            background: #F7FAFC;
            border: 1px solid #E2E8F0;
            transition: all 0.2s ease;
        }

        .page-number:hover {
            color: #FFFFFF;
            background: #A893C4;
            border-color: #A893C4;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(168, 147, 196, 0.2);
        }

        .page-number-active {
            color: #FFFFFF;
            background: linear-gradient(135deg, #8B7BA8 0%, #A893C4 100%);
            border-color: #8B7BA8;
            box-shadow: 0 2px 8px rgba(139, 123, 168, 0.3);
        }

        .page-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            color: #A0AEC0;
            font-weight: 500;
        }

        .btn-text {
            font-size: 0.9rem;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .modern-pagination-container {
                margin: 1.5rem 0;
            }

            .pagination-nav {
                padding: 0.5rem 1rem;
                gap: 0.25rem;
            }

            .pagination-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .page-number {
                width: 2rem;
                height: 2rem;
                font-size: 0.8rem;
            }

            .btn-text {
                display: none;
            }

            .page-numbers {
                margin: 0 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .pagination-nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .page-numbers {
                order: -1;
                margin: 0 0 0.5rem 0;
            }
        }
    </style>
@endif
