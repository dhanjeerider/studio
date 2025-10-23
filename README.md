# Next.js on Cloudflare Pages

This is a Next.js project configured for deployment on Cloudflare Pages.

## Getting Started

### Development

```bash
npm install
npm run dev
```

Open [http://localhost:3000](http://localhost:3000) to view the application.

### Building for Cloudflare Pages

```bash
# Build the Next.js application
npm run build

# Build for Cloudflare Pages
npm run pages:build
```

The build output will be in `.vercel/output/static`.

### Deployment

To deploy to Cloudflare Pages:

```bash
npm run pages:deploy
```

Or manually deploy the `.vercel/output/static` directory using the Cloudflare Pages dashboard.

## Configuration

- **Next.js Version**: 15.5.2 (required for Cloudflare Pages compatibility)
- **Runtime**: Edge runtime for dynamic routes
- **Build Output**: `.vercel/output/static` (configured in `wrangler.toml`)

## Project Structure

- `src/app/` - Next.js app directory
- `src/components/` - React components
- `wrangler.toml` - Cloudflare Pages configuration
- `next.config.ts` - Next.js configuration

