# TMDB Proxy for Cloudflare Pages

A Next.js application that acts as a reverse proxy for The Movie Database (TMDB) API, deployed on Cloudflare Pages. This helps bypass ISP blocking (like Jio in India) and provides fast CDN-based JSON responses.

## 🚀 Quick Deploy to Cloudflare Pages

### Method 1: Using Cloudflare Dashboard (Easiest)

1. **Fork or push this repository to GitHub**
2. **Go to [Cloudflare Dashboard](https://dash.cloudflare.com/)**
3. **Navigate to Workers & Pages > Create Application > Pages > Connect to Git**
4. **Select this repository**
5. **Configure build settings:**
   - **Build command:** `npm run cf:build`
   - **Build output directory:** `.vercel/output/static`
6. **Click "Save and Deploy"**

### Method 2: Using Wrangler CLI

1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Build for Cloudflare Pages:**
   ```bash
   npm run cf:build
   ```

3. **Deploy to Cloudflare Pages:**
   ```bash
   npm run pages:deploy
   ```

   Or manually:
   ```bash
   npx wrangler pages deploy .vercel/output/static
   ```

## 💻 Local Development

Run the development server:
```bash
npm run dev
```

Preview with Cloudflare Pages locally:
```bash
npm run pages:dev
```

## 📖 Usage

Once deployed, use your Cloudflare Pages URL as the base URL for TMDB API requests:
```
https://your-app.pages.dev/tmdb/movie/popular?api_key=YOUR_API_KEY
```

Example endpoints:
- Get movie details: `/tmdb/movie/609681?api_key=YOUR_KEY`
- Popular movies: `/tmdb/movie/popular?api_key=YOUR_KEY`
- Search: `/tmdb/search/movie?api_key=YOUR_KEY&query=avengers`

## 🔧 Scripts

- `npm run dev` - Start Next.js development server
- `npm run build` - Build Next.js application
- `npm run cf:build` - Build for Cloudflare Pages deployment
- `npm run pages:deploy` - Build and deploy to Cloudflare Pages
- `npm run lint` - Run ESLint

## 📝 Configuration

- **wrangler.toml** - Cloudflare Pages configuration
- **next.config.ts** - Next.js configuration optimized for Cloudflare
- **Edge Runtime** - API routes use Cloudflare's edge runtime for optimal performance

---

Made by [DHANJEE RIDER](https://t.me/+_lJ14CGAOgkxNGM9)
