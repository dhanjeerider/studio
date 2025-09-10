import { CodeBlock } from "@/components/code-block";

const apiKey = "e2f36edd5828037f897c065caca5156f";
const baseUrl =
  typeof window !== "undefined"
    ? window.location.origin
    : "https://studio-two-rust.vercel.app";

export default function Home() {
  return (
    <main className="flex min-h-screen flex-col items-center justify-center p-4 sm:p-6 md:p-24">
      <div className="w-full max-w-4xl space-y-8">
        <div className="text-center">
          <h1 className="text-4xl font-bold tracking-tight sm:text-5xl">
            Indie TMDB Proxy
          </h1>
          <p className="mt-4 text-lg text-muted-foreground">
            A simple, open-source reverse proxy for The Movie Database API.
          </p>
        </div>

        <div className="space-y-6 rounded-lg border bg-card text-card-foreground shadow-sm p-6">
          <div className="space-y-2">
            <h2 className="font-semibold text-2xl">API Documentation</h2>
            <p className="text-sm text-muted-foreground">
              Use this application's URL as a proxy to the TMDB API. Click any
              endpoint to open it in a new tab, or use the copy button.
            </p>
          </div>

          <div className="space-y-2">
            <h3 className="font-semibold">Base Proxy URL</h3>
            <p className="text-sm text-muted-foreground">
              All TMDB API requests should start with this base URL.
            </p>
            <CodeBlock>{baseUrl}</CodeBlock>
          </div>

          {/* Movie Endpoints */}
          <div className="space-y-4">
            <h3 className="font-semibold">Movie Endpoints</h3>
            <CodeBlock>{`${baseUrl}/movie/609681?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/movie/popular?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/movie/top_rated?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/movie/upcoming?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/movie/now_playing?api_key=${apiKey}`}</CodeBlock>
          </div>

          {/* TV Endpoints */}
          <div className="space-y-4">
            <h3 className="font-semibold">TV Show Endpoints</h3>
            <CodeBlock>{`${baseUrl}/tv/66573?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/tv/popular?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/tv/top_rated?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/tv/on_the_air?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/tv/airing_today?api_key=${apiKey}`}</CodeBlock>
          </div>

          {/* Discover */}
          <div className="space-y-4">
            <h3 className="font-semibold">Discover Endpoints</h3>
            <CodeBlock>{`${baseUrl}/discover/movie?api_key=${apiKey}&with_genres=28&sort_by=popularity.desc`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/discover/tv?api_key=${apiKey}&with_genres=35&sort_by=first_air_date.desc`}</CodeBlock>
          </div>

          {/* Genres */}
          <div className="space-y-4">
            <h3 className="font-semibold">Genre Endpoints</h3>
            <CodeBlock>{`${baseUrl}/genre/movie/list?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/genre/tv/list?api_key=${apiKey}`}</CodeBlock>
          </div>

          {/* Person */}
          <div className="space-y-4">
            <h3 className="font-semibold">Person Endpoints</h3>
            <CodeBlock>{`${baseUrl}/person/287?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/person/287/images?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/person/287/movie_credits?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/person/287/tv_credits?api_key=${apiKey}`}</CodeBlock>
          </div>

          {/* Trending */}
          <div className="space-y-4">
            <h3 className="font-semibold">Trending Endpoints</h3>
            <CodeBlock>{`${baseUrl}/trending/all/day?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/trending/movie/day?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/trending/tv/day?api_key=${apiKey}`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/trending/person/week?api_key=${apiKey}`}</CodeBlock>
          </div>

          {/* Advanced */}
          <div className="space-y-4">
            <h3 className="font-semibold">Advanced Details</h3>
            <CodeBlock>{`${baseUrl}/movie/609681?api_key=${apiKey}&append_to_response=credits,images,videos,keywords,reviews,recommendations,similar,release_dates,watch/providers`}</CodeBlock>
            <CodeBlock>{`${baseUrl}/tv/66573?api_key=${apiKey}&append_to_response=credits,images,videos,keywords,reviews,recommendations,similar,content_ratings,watch/providers`}</CodeBlock>
          </div>
        </div>
      </div>
    </main>
  );
}
