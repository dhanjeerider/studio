import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

const movieEndpoint = `/api/movie/{movie_id}`;
const tvEndpoint = `/api/tv/{tv_id}`;

const exampleResponse = {
  "id": 609681,
  "title": "The Marvels",
  "overview": "Carol Danvers, aka Captain Marvel, has reclaimed her identity...",
  "release_date": "2023-11-08",
  "vote_average": 6.2,
  "...": "..."
};

export default function ApiDocsPage() {
  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <CardTitle>API Documentation</CardTitle>
          <CardDescription>
            Use our API to access the cloned TMDB data. This is particularly useful in regions where the official TMDB API is not accessible.
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <p>
            The API is designed to be a simple, drop-in replacement for the basic TMDB endpoints.
            All responses are returned in JSON format.
          </p>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Movie Details</CardTitle>
          <CardDescription>
            Retrieve the details of a specific movie.
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <div>
            <h3 className="font-semibold">Endpoint</h3>
            <pre className="text-sm bg-muted p-2 mt-1 rounded-lg font-mono">
              <code>GET {movieEndpoint}</code>
            </pre>
          </div>
          <div>
            <h3 className="font-semibold">Example</h3>
            <pre className="text-sm bg-muted p-2 mt-1 rounded-lg font-mono">
              <code>/api/movie/609681</code>
            </pre>
          </div>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>TV Show Details</CardTitle>
          <CardDescription>
            Retrieve the details of a specific TV show.
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <div>
            <h3 className="font-semibold">Endpoint</h3>
            <pre className="text-sm bg-muted p-2 mt-1 rounded-lg font-mono">
              <code>GET {tvEndpoint}</code>
            </pre>
          </div>
          <div>
            <h3 className="font-semibold">Example</h3>
            <pre className="text-sm bg-muted p-2 mt-1 rounded-lg font-mono">
              <code>/api/tv/66573</code>
            </pre>
          </div>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Example Response</CardTitle>
          <CardDescription>
            Below is a truncated example of a movie details response.
          </CardDescription>
        </CardHeader>
        <CardContent>
          <pre className="text-xs bg-muted p-4 rounded-lg">
            <code>{JSON.stringify(exampleResponse, null, 2)}</code>
          </pre>
        </CardContent>
      </Card>
    </div>
  );
}
