import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
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
        <Card>
          <CardHeader>
            <CardTitle>API Documentation</CardTitle>
            <CardDescription>
              Use your application's URL as a proxy to the TMDB API. You must include your TMDB API key as a query parameter in each request.
            </CardDescription>
          </CardHeader>
          <CardContent className="space-y-6">
            <div className="space-y-2">
              <h3 className="font-semibold">Base Proxy URL</h3>
              <p className="text-sm text-muted-foreground">
                All TMDB API requests should be prefixed with this path.
              </p>
              <CodeBlock>/api/tmdb</CodeBlock>
            </div>

            <div className="space-y-2">
              <h3 className="font-semibold">Examples</h3>
              <p className="text-sm text-muted-foreground">
                Simply replace <code>https://api.themoviedb.org/3</code> with your application's URL followed by <code>/api/tmdb</code>, and add your API key.
              </p>
              <div className="space-y-4">
                <div>
                  <h4 className="font-medium text-sm">Get Movie Details:</h4>
                  <p className="text-xs text-muted-foreground mb-1">Original TMDB Path: <code>/movie/609681?api_key=...</code></p>
                  <CodeBlock>/api/tmdb/movie/609681?api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Discover Movies:</h4>
                  <p className="text-xs text-muted-foreground mb-1">Original TMDB Path: <code>/discover/movie?sort_by=popularity.desc&api_key=...</code></p>
                  <CodeBlock>/api/tmdb/discover/movie?sort_by=popularity.desc&api_key=YOUR_API_KEY</CodeBlock>
                </div>
                <div>
                  <h4 className="font-medium text-sm">Search for a Movie:</h4>
                  <p className="text-xs text-muted-foreground mb-1">Original TMDB Path: <code>/search/movie?query=Inception&api_key=...</code></p>
                  <CodeBlock>/api/tmdb/search/movie?query=Inception&api_key=YOUR_API_KEY</CodeBlock>
                </div>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </main>
  );
}
