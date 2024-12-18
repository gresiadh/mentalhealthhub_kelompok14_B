@extends('layouts.app')

@section('content')
    <section style="color: black; background: #bad3d9;" class="py-5" id="about">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <!-- Card Section -->
                    <div class="card shadow-lg" style="border-radius: 15px; background-color: #e7eaef; color: #0c2839;">
                        
                        <!-- Header Section -->
                        <div class="card-header text-center" style="border-radius: 15px 15px 0 0; background-color: #0c2839;">
                            <h2 class="mb-0" style="font-weight: bold; font-family: 'Arial', sans-serif; color: white;">
                                {{ $blog->title }}
                            </h2>
                            <p class="mt-2" style="font-size: 0.9rem; color: #f1faee;">
                                {{ $blog->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <!-- Body Section -->
                        <div class="card-body text-center">
                            <!-- Blog Thumbnail -->
                            <div class="d-flex justify-content-center mb-4">
                                <img src="/{{ $blog->thumbnail }}" 
                                     class="img-fluid rounded" 
                                     alt="Blog Image" 
                                     style="max-height: 400px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);">
                            </div>

                            <!-- Blog Description -->
                            <!-- Blog Description -->
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <p style="font-size: 1.1rem; color: #333333; line-height: 1.8; text-align: justify;">
                                        {{ $blog->description }}
                                    </p>
                                </div>
                            </div>

                            </div>
                        </div>

                        <!-- Footer Section -->
                        <div class="card-footer text-center" style="border-radius: 0 0 15px 15px; background-color: #071932;">
                            <a href="/blogs" 
                               class="btn btn-light" 
                               style="padding: 0.6rem 1.5rem; font-size: 0.9rem; text-transform: uppercase; color: #b1b5b8; font-weight: bold;">
                                Kembali ke Semua Artikel
                            </a>
                        </div>

                    </div> <!-- End Card -->
                </div>
            </div>
        </div>
    </section>
@endsection
