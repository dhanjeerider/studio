import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";

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
            <p>You can now use this application to make requests to the TMDB API, even from regions where it might be blocked.</p>
            <p className="mt-4">Head over to the <strong>Manual Clone</strong> page to test it out.</p>
        </CardContent>
      </Card>
    </div>
  );
}
