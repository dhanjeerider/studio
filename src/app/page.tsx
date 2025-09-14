import { CodeBlock } from "@/components/code-block";

const apiKey = "e2f36edd5828037f897c065caca5156f";

export default function Home() {
  return (
    <main className="flex min-h-screen flex-col items-center justify-center p-4 sm:p-6 md:p-24">
      <div className="w-full max-w-4xl space-y-8">
        <div className="text-center">
          <h1 className="text-4xl font-bold tracking-tight sm:text-5xl">Indian TMDB Proxy</h1>
          <p className="mt-4 text-lg text-muted-foreground">
            A simple, open-source reverse proxy for The Movie Database API. which helps to load TMDB api in India 🙂‍↔️ jio isp blocking bypass and fast loading cdn json response <br /> made by <a href="https://t.me/+_lJ14CGAOgkxNGM9"><b>DHANJEE RIDER </b></a>in 1 sep 2025 
          </p>
        </div>
        <div className="space-y-6 rounded-lg border bg-card text-card-foreground shadow-sm p-6">
            <div className="space-y-2">
              <h2 className="font-semibold text-2xl">API Documentation</h2>
              <p className="text-sm text-muted-foreground">
                Use this application's URL as a proxy to the TMDB API. Click any endpoint to open it in a new tab, or use the copy button.
              </p>
            </div>

            <div className="space-y-2">
              <h3 className="font-semibold">Base Proxy URL</h3>
              <p className="text-sm text-muted-foreground">
                All TMDB API requests should be prefixed with this path. if you have a tMDB streming script then serch for tmdb js and add this as base url to load your website in India 🙂‍↔️ 
              </p>
              <CodeBlock>https://dktczn.vercel.app/tmdb</CodeBlock>
            </div>

            <div className="space-y-4">
              <h3 className="font-semibold">Movie Endpoints</h3>
                <div>
                  <h4 className="font-medium text-sm">Get Movie Details:</h4>
                  <CodeBlock>{`/tmdb/movie/609681?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Popular Movies:</h4>
                  <CodeBlock>{`/tmdb/movie/popular?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Top Rated Movies:</h4>
                  <CodeBlock>{`/tmdb/movie/top_rated?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Upcoming Movies:</h4>
                  <CodeBlock>{`/tmdb/movie/upcoming?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Now Playing Movies:</h4>
                  <CodeBlock>{`/tmdb/movie/now_playing?api_key=${apiKey}`}</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
              <h3 className="font-semibold">TV Show Endpoints</h3>
                <div>
                  <h4 className="font-medium text-sm">Get TV Show Details:</h4>
                  <CodeBlock>{`/tmdb/tv/66573?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Popular TV Shows:</h4>
                  <CodeBlock>{`/tmdb/tv/popular?api_key=${apiKey}`}</CodeBlock>
                </div>
                 <div>
                  <h4 className="font-medium text-sm">Top Rated TV Shows:</h4>
                  <CodeBlock>{`/tmdb/tv/top_rated?api_key=${apiKey}`}</CodeBlock>
                </div>
                 <div>
                  <h4 className="font-medium text-sm">On The Air TV Shows:</h4>
                  <CodeBlock>{`/tmdb/tv/on_the_air?api_key=${apiKey}`}</CodeBlock>
                </div>
                 <div>
                  <h4 className="font-medium text-sm">Airing Today TV Shows:</h4>
                  <CodeBlock>{`/tmdb/tv/airing_today?api_key=${apiKey}`}</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
                <h3 className="font-semibold">Discover Endpoints</h3>
                <div>
                    <h4 className="font-medium text-sm">Discover Movies:</h4>
                    <CodeBlock>{`/tmdb/discover/movie?api_key=${apiKey}&with_genres=28&sort_by=popularity.desc`}</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Discover TV Shows:</h4>
                    <CodeBlock>{`/tmdb/discover/tv?api_key=${apiKey}&with_genres=35&sort_by=first_air_date.desc`}</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
                <h3 className="font-semibold">Genre Endpoints</h3>
                <div>
                    <h4 className="font-medium text-sm">Movie Genres:</h4>
                    <CodeBlock>{`/tmdb/genre/movie/list?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">TV Show Genres:</h4>
                    <CodeBlock>{`/tmdb/genre/tv/list?api_key=${apiKey}`}</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
                <h3 className="font-semibold">Person Endpoints</h3>
                <div>
                    <h4 className="font-medium text-sm">Person Details:</h4>
                    <CodeBlock>{`/tmdb/person/287?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Person Images:</h4>
                    <CodeBlock>{`/tmdb/person/287/images?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Person Movie Credits:</h4>
                    <CodeBlock>{`/tmdb/person/287/movie_credits?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Person TV Credits:</h4>
                    <CodeBlock>{`/tmdb/person/287/tv_credits?api_key=${apiKey}`}</CodeBlock>
                </div>
            </div>

            <div className="space-y-4">
                <h3 className="font-semibold">Trending Endpoints</h3>
                <div>
                    <h4 className="font-medium text-sm">Trending All (Daily):</h4>
                    <CodeBlock>{`/tmdb/trending/all/day?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Trending Movies (Daily):</h4>
                    <CodeBlock>{`/tmdb/trending/movie/day?api_key=${apiKey}`}</CodeBlock>
                </div>
                 <div>
                    <h4 className="font-medium text-sm">Trending TV (Daily):</h4>
                    <CodeBlock>{`/tmdb/trending/tv/day?api_key=${apiKey}`}</CodeBlock>
                </div>
                <div>
                    <h4 className="font-medium text-sm">Trending People (Weekly):</h4>
                    <CodeBlock>{`/tmdb/trending/person/week?api_key=${apiKey}`}</CodeBlock>
                </div>
            </div>
             <div className="space-y-4">
              <h3 className="font-semibold">Advanced Details</h3>
                <div>
                  <h4 className="font-medium text-sm">Get All Movie Details:</h4>
                  <CodeBlock>{`/tmdb/movie/609681?api_key=${apiKey}&append_to_response=credits,images,videos,keywords,reviews,recommendations,similar,release_dates,watch/providers`}</CodeBlock>
                </div>
                 <div>
                  <h4 className="font-medium text-sm">Get All TV Show Details:</h4>
                  <CodeBlock>{`/tmdb/tv/66573?api_key=${apiKey}&append_to_response=credits,images,videos,keywords,reviews,recommendations,similar,content_ratings,watch/providers`}</CodeBlock>
                </div>
            </div>
          </div>
      </div>
    </main>
  );
} 
