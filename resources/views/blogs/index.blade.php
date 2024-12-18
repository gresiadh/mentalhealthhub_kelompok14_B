@extends('layouts.app')

@section('content')
    <section style="color: black; background: #bad3d9;" class="py-5 d-flex align-items-center" id="about">
        <div class="container">
            <div class="row mt-5 text-center">
                <div class="col-md-12">
                    <h3 style="font-weight: bold; font-family: Arial, sans-serif;">Semua Artikel</h3>
                </div>
            </div>

            <div class="row mt-4">

                @foreach ($blogs as $item)

                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm" style="border: none; border-radius: 10px;">
                        <img src="/{{ $item->thumbnail }}" style="height: 250px; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;" alt="">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 1.2rem; font-weight: bold; color: #333;">{{ $item->title }}</h5>
                            <p class="card-text" style="color: #555; font-size: 0.95rem;">
                                {{ substr($item->description, 0, 50) }}...
                            </p>
                            <a href="/blogs/{{ $item->id }}" class="btn btn-primary mt-3" style="background-color: #0044cc; border: none; font-size: 0.9rem; padding: 0.5rem 1.5rem;">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
