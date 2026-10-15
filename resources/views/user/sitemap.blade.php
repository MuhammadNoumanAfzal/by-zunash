{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <!-- Homepage -->
    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Shop / Main Catalog -->
    <url>
        <loc>{{ route('shop') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Brand Story & Support -->
    <url>
        <loc>{{ route('about') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ route('faq') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>

    <!-- Product Categories -->
    @foreach($categories as $slug => $cat)
    <url>
        <loc>{{ route('category', $slug) }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.85</priority>
        @if(!empty($cat['image']))
        <image:image>
            <image:loc>{{ $cat['image'] }}</image:loc>
            <image:title>{{ $cat['name'] }} - By Zunash Luxury Leather</image:title>
            <image:caption>{{ $cat['tagline'] }}</image:caption>
        </image:image>
        @endif
    </url>
    @endforeach

    <!-- All Products with Image Sitemap extensions -->
    @foreach($products as $product)
    <url>
        <loc>{{ route('product.details', $product['slug']) }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        @if(!empty($product['image']))
        <image:image>
            <image:loc>{{ $product['image'] }}</image:loc>
            <image:title>{{ $product['name'] }}</image:title>
            <image:caption>{{ $product['short_description'] ?? $product['name'] }}</image:caption>
        </image:image>
        @endif
    </url>
    @endforeach

    <!-- Policies -->
    <url>
        <loc>{{ route('policy.shipping') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ route('policy.returns') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>{{ route('policy.privacy') }}</loc>
        <lastmod>{{ date('Y-m-d') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
</urlset>
