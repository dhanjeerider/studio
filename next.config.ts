import type {NextConfig} from 'next';

const nextConfig: NextConfig = {
  /* config options here */
  typescript: {
    ignoreBuildErrors: true,
  },
  eslint: {
    ignoreDuringBuilds: true,
  },
  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: 'placehold.co',
        port: '',
        pathname: '/**',
      },
      {
        protocol: 'https',
        hostname: 'images.unsplash.com',
        port: '',
        pathname: '/**',
      },
      {
        protocol: 'https',
        hostname: 'picsum.photos',
        port: '',
        pathname: '/**',
      },
    ],
  },
  async rewrites() {
    return [
      {
        source: '/movie/:path*',
        destination: '/tmdb/movie/:path*',
      },
      {
        source: '/tv/:path*',
        destination: '/tmdb/tv/:path*',
      },
      {
        source: '/discover/:path*',
        destination: '/tmdb/discover/:path*',
      },
      {
        source: '/genre/:path*',
        destination: '/tmdb/genre/:path*',
      },
      {
        source: '/person/:path*',
        destination: '/tmdb/person/:path*',
      },
      {
        source: '/trending/:path*',
        destination: '/tmdb/trending/:path*',
      },
    ];
  },
};

export default nextConfig;
