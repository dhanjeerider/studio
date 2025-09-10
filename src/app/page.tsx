import { CodeBlock } from "@/components/code-block";

export default function Home() {
  const endpoints = {
    "Movie Endpoints": [
      { title: "Basic detail", path: "/movie/{movie_id}" },
      { title: "Popular movies", path: "/movie/popular" },
      { title: "Top rated movies", path: "/movie/top_rated" },
      { title: "Upcoming movies", path: "/movie/upcoming" },
      { title: "Now playing", path: "/movie/now_playing" },
    ],
    "TV Show Endpoints": [
      { title: "Basic detail", path: "/tv/{tv_id}" },
      { title: "Popular TV shows", path: "/tv/popular" },
      { title: "Top rated shows", path: "/tv/top_rated" },
      { title: "On the air", path: "/tv/on_the_air" },
      { title: "Airing today", path: "/tv/airing_today" },
    ],
    "Discover Endpoints": [
      { title: "Movies discover", path: "/discover/movie?with_genres=28&sort_by=popularity.desc&page=1" },
      { title: "TV discover", path: "/discover/tv?with_genres=35&sort_by=first_air_date.desc&page=1" },
    ],
    "Genre Endpoints": [
      { title: "All movie genres list", path: "/genre/movie/list" },
      { title: "All TV genres list", path: "/genre/tv/list" },
    ],
    "Person Endpoints": [
      { title: "Person detail", path: "/person/{person_id}" },
      { title: "Person images", path: "/person/{person_id}/images" },
      { title: "Person movie credits", path: "/person/{person_id}/movie_credits" },
      { title: "Person TV credits", path: "/person/{person_id}/tv_credits" },
    ],
    "Trending Endpoints": [
      { title: "Trending movies (day)", path: "/trending/movie/day" },
      { title: "Trending movies (week)", path: "/trending/movie/week" },
      { title: "Trending TV (day)", path: "/trending/tv/day" },
      { title: "Trending people (week)", path: "/trending/person/week" },
      { title: "All trending (day)", path: "/trending/all/day" },
    ],
  };

  return (
    <main className="flex min-h-screen flex-col items-center justify-center p-4 sm:p-6 md:p-24 bg-gray-900 text-white">
      <div className="w-full max-w-4xl space-y-8">
        <div className="text-center">
          <h1 className="text-4xl font-bold tracking-tight sm:text-5xl">Indie TMDB Proxy</h1>
          <p className="mt-4 text-lg text-gray-400">
            A simple, open-source reverse proxy for The Movie Database API.
          </p>
        </div>
        <div className="space-y-6 rounded-lg border border-gray-700 bg-gray-800 p-6 shadow-md">
            <div className="space-y-2">
              <h3 className="font-semibold text-2xl">API Documentation</h3>
              <p className="text-sm text-gray-400">
                Use this application&apos;s URL as a proxy to the TMDB API. All TMDB API requests should be prefixed with the path below. You must include your TMDB API key as a query parameter in each request.
              </p>
            </div>

            <div className="space-y-2">
              <h3 className="font-semibold">Base Proxy URL</h3>
              <CodeBlock>/api/tmdb</CodeBlock>
            </div>

            <div className="space-y-2">
              <h3 className="font-semibold">Example Request</h3>
              <p className="text-sm text-gray-400">
                To get popular movies, you would make a request like this (appending the TMDB path to the base proxy URL):
              </p>
              <CodeBlock>/api/tmdb/movie/popular?api_key=YOUR_API_KEY</CodeBlock>
            </div>
        </div>

        <div className="space-y-6 rounded-lg border border-gray-700 bg-gray-800 p-6 shadow-md">
          <h3 className="font-semibold text-2xl">Available Endpoints</h3>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
            {Object.entries(endpoints).map(([category, items]) => (
              <div key={category} className="space-y-3">
                <h4 className="font-semibold text-lg border-b border-gray-600 pb-2">{category}</h4>
                <ul className="space-y-2 text-sm">
                  {items.map((item) => (
                    <li key={item.path}>
                      <p className="text-gray-300">{item.title}</p>
                      <CodeBlock>
                        {`/api/tmdb${item.path}${item.path.includes('?') ? '&' : '?'}api_key=YOUR_API_KEY`}
                      </CodeBlock>
                    </li>
                  ))}
                </ul>
              </div>
            ))}
          </div>
        </div>

      </div>
    </main>
  );
}
