import { CodeBlock } from "@/components/code-block";

export default function Home() {
  return (
    <main className="flex min-h-screen flex-col items-center justify-center p-4 sm:p-6 md:p-24">
      <div className="w-full max-w-4xl space-y-8">
        <div className="text-center">
          <h1 className="text-4xl font-bold tracking-tight sm:text-5xl">Indie TMDB Proxy</h1>
          <p className="mt-4 text-lg text-muted-foreground">
            A simple, open-source reverse proxy for The Movie Database API.
          </p>
        </div>
        <div className="space-y-6 rounded-lg border bg-card text-card-foreground shadow-sm p-6">
            <div className="space-y-2">
              <h3 className="font-semibold text-2xl">API Documentation</h3>
              <p className="text-sm text-muted-foreground">
                Use this application's URL as a proxy to the TMDB API. You must include your TMDB API key as a query parameter in each request.
              </p>
            </div>

            <div className="space-y-2">
              <h3 className="font-semibold">Base Proxy URL</h3>
              <p className="text-sm text-muted-foreground">
                All TMDB API requests should be prefixed with this path.
              </p>
              <CodeBlock>/api/tmdb</CodeBlock>
            </div>

            <div className="space-y-4">
              <h3 className="font-semibold">Movie Endpoints</h3>
                <div>
                  <h4 className="font-medium text-sm">Get Movie Details:</h4>
                  <CodeBlock>/api/tmdb/movie/609681?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Popular Movies:</h4>
                  <CodeBlock>/api/tmdb/movie/popular?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Top Rated Movies:</h4>
                  <CodeBlock>/api/tmdb/movie/top_rated?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Upcoming Movies:</h4>
                  <CodeBlock>/api/tmdb/movie/upcoming?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Now Playing Movies:</h4>
                  <CodeBlock>/api/tmdb/movie/now_playing?api_key=YOUR_API_KEY</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
              <h3 className="font-semibold">TV Show Endpoints</h3>
                <div>
                  <h4 className="font-medium text-sm">Get TV Show Details:</h4>
                  <CodeBlock>/api/tmdb/tv/66573?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Popular TV Shows:</h4>
                  <CodeBlock>/api/tmdb/tv/popular?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                 <div>
                  <h4 className="font-medium text-sm">Top Rated TV Shows:</h4>
                  <CodeBlock>/api/tmdb/tv/top_rated?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                 <div>
                  <h4 className="font-medium text-sm">On The Air TV Shows:</h4>
                  <CodeBlock>/api/tmdb/tv/on_the_air?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                 <div>
                  <h4 className="font-medium text-sm">Airing Today TV Shows:</h4>
                  <CodeBlock>/api/tmdb/tv/airing_today?api_key=YOUR_API_KEY</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
                <h3 className="font-semibold">Discover Endpoints</h3>
                <div>
                    <h4 className="font-medium text-sm">Discover Movies:</h4>
                    <CodeBlock>/api/tmdb/discover/movie?with_genres=28&amp;sort_by=popularity.desc&amp;api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Discover TV Shows:</h4>
                    <CodeBlock>/api/tmdb/discover/tv?with_genres=35&amp;sort_by=first_air_date.desc&amp;api_key=YOUR_API_KEY</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
                <h3 className="font-semibold">Genre Endpoints</h3>
                <div>
                    <h4 className="font-medium text-sm">Movie Genres:</h4>
                    <CodeBlock>/api/tmdb/genre/movie/list?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">TV Show Genres:</h4>
                    <CodeBlock>/api/tmdb/genre/tv/list?api_key=YOUR_API_KEY</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
                <h3 className="font-semibold">Person Endpoints</h3>
                <div>
                    <h4 className="font-medium text-sm">Person Details:</h4>
                    <CodeBlock>/api/tmdb/person/287?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Person Images:</h4>
                    <CodeBlock>/api/tmdb/person/287/images?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Person Movie Credits:</h4>
                    <CodeBlock>/api/tmdb/person/287/movie_credits?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Person TV Credits:</h4>
                    <CodeBlock>/api/tmdb/person/287/tv_credits?api_key=YOUR_API_KEY</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
                <h3 className="font-semibold">Trending Endpoints</h3>
                <div>
                    <h4 className="font-medium text-sm">Trending Movies (Daily):</h4>
                    <CodeBlock>/api/tmdb/trending/movie/day?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                 <div>
                    <h4 className="font-medium text-sm">Trending TV (Daily):</h4>
                    <CodeBlock>/api/tmdb/trending/tv/day?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Trending People (Weekly):</h4>
                    <CodeBlock>/api/tmdb/trending/person/week?api_key=YOUR_API_KEY</CodeBlock>
                </div>
            </div>
          </div>
      </div>
    </main>
  );
}
