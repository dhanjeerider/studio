export default function Home() {
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
                Use this application's URL as a proxy to the TMDB API. All TMDB API requests should be prefixed with the path below. You must include your TMDB API key as a query parameter in each request.
              </p>
            </div>

            <div className="space-y-2">
              <h3 className="font-semibold">Base Proxy URL</h3>
              <pre className="text-xs bg-gray-700 p-4 rounded-lg"><code>/api/tmdb</code></pre>
            </div>

            <div className="space-y-2">
              <h3 className="font-semibold">Example Request</h3>
              <p className="text-sm text-gray-400">
                To get popular movies, you would make a request like this:
              </p>
              <pre className="text-xs bg-gray-700 p-4 rounded-lg"><code>/api/tmdb/movie/popular?api_key=YOUR_API_KEY</code></pre>
            </div>
        </div>
      </div>
    </main>
  );
}
