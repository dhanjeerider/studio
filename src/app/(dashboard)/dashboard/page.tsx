import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { CodeBlock } from "@/components/code-block";

export default function DashboardPage() {
  return (
    <div className="flex flex-col gap-6">
       <Card>
        <CardHeader>
          <CardTitle>Welcome to your TMDB Proxy</CardTitle>
          <CardDescription>
            You have successfully set up a reverse proxy for The Movie Database (TMDB) API.
          </CardDescription>
        </CardHeader>
        <CardContent>
            <p>You can now use this application to make requests to the TMDB API, even from regions where it might be blocked. See the documentation below for how to use it.</p>
            <p className="mt-4">Head over to the <strong>Manual Clone</strong> page to test out a specific ID.</p>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>API Documentation</CardTitle>
          <CardDescription>
            Use your application's URL as a proxy to the TMDB API. You'll need to have your TMDB read access token in the <code>.env</code> file.
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
              Simply replace <code>https://api.themoviedb.org/3</code> with your application's URL followed by <code>/api/tmdb</code>.
            </p>
            <div className="space-y-4">
              <div>
                <h4 className="font-medium text-sm">Get Movie Details:</h4>
                <p className="text-xs text-muted-foreground mb-1">Original TMDB Path: <code>/movie/609681</code></p>
                <CodeBlock>/api/tmdb/movie/609681</CodeBlock>
              </div>
              <div>
                <h4 className="font-medium text-sm">Get All Movie Details (with append_to_response):</h4>
                <p className="text-xs text-muted-foreground mb-1">Original TMDB Path: <code>/movie/609681?append_to_response=...</code></p>
                <CodeBlock>/api/tmdb/movie/609681?append_to_response=credits,images,videos,keywords,reviews,recommendations,similar,release_dates,watch/providers</CodeBlock>
              </div>
              <div>
                <h4 className="font-medium text-sm">Get TV Show Details:</h4>
                <p className="text-xs text-muted-foreground mb-1">Original TMDB Path: <code>/tv/66573</code></p>
                <CodeBlock>/api/tmdb/tv/66573</CodeBlock>
              </div>
              <div>
                <h4 className="font-medium text-sm">Get All TV Show Details (with append_to_response):</h4>
                <p className="text-xs text-muted-foreground mb-1">Original TMDB Path: <code>/tv/66573?append_to_response=...</code></p>
                <CodeBlock>/api/tmdb/tv/66573?append_to_response=credits,images,videos,keywords,reviews,recommendations,similar,content_ratings,watch/providers</CodeBlock>
              </div>
              <div>
                <h4 className="font-medium text-sm">Discover Movies:</h4>
                <p className="text-xs text-muted-foreground mb-1">Original TMDB Path: <code>/discover/movie?sort_by=popularity.desc</code></p>
                <CodeBlock>/api/tmdb/discover/movie?sort_by=popularity.desc</CodeBlock>
              </div>
               <div>
                <h4 className="font-medium text-sm">Search for a Movie:</h4>
                <p className="text-xs text-muted-foreground mb-1">Original TMDB Path: <code>/search/movie?query=Inception</code></p>
                <CodeBlock>/api/tmdb/search/movie?query=Inception</CodeBlock>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
