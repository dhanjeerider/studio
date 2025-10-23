# TMDB Proxy for Cloudflare Pages

A Next.js application that acts as a reverse proxy for The Movie Database (TMDB) API, deployed on Cloudflare Pages. This helps bypass ISP blocking (like Jio in India) and provides fast CDN-based JSON responses.

## Deploy to Cloudflare Pages

### Prerequisites
- Node.js 20 or higher
- A Cloudflare account
- Wrangler CLI installed (`npm install -g wrangler`)

### Deployment Steps

1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Build for Cloudflare Pages:**
   ```bash
   npm run build
   ```

3. **Deploy to Cloudflare Pages:**
   ```bash
   npm run pages:deploy
   ```

   Or manually:
   ```bash
   wrangler pages deploy .vercel/output/static
   ```

### Local Development

Run the development server:
```bash
npm run dev
```

Preview with Cloudflare Pages locally:
```bash
npm run pages:dev
```

### Usage

Once deployed, use your Cloudflare Pages URL as the base URL for TMDB API requests:
```
https://your-app.pages.dev/tmdb/movie/popular?api_key=YOUR_API_KEY
```

Made by [DHANJEE RIDER](https://t.me/+_lJ14CGAOgkxNGM9)
