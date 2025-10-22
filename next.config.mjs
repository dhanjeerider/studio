
/** @type {import('next').NextConfig} */
const nextConfig = {
  async rewrites() {
    return [
      {
        source: '/tmdb/:path*',
        destination: 'https://api.themoviedb.org/3/:path*',
      },
    ];
  },
};

export default nextConfig;
