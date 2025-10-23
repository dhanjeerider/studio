import { NextResponse, type NextRequest } from "next/server";

const TMDB_BASE_URL = "https://api.themoviedb.org/3";

export async function GET(
  request: NextRequest,
  { params }: { params: { slug: string[] } }
) {
  const { slug } = params;
  const { search, searchParams } = new URL(request.url);

  const tmdbPath = slug.join("/");

  const apiKey = searchParams.get("api_key");
  if (!apiKey) {
    return NextResponse.json(
      { error: "api_key query parameter is required." },
      { status: 400 }
    );
  }

  const tmdbUrl = `${TMDB_BASE_URL}/${tmdbPath}${search}`;

  try {
    const tmdbResponse = await fetch(tmdbUrl, {
      headers: { "Content-Type": "application/json" },
      cache: "no-store", // caching bug fix
    });

    const data = await tmdbResponse.json();

    const res = NextResponse.json(data, { status: tmdbResponse.status });

    // --- Fix: Allow all sites + iframe ---
    res.headers.set("Access-Control-Allow-Origin", "*");
    res.headers.set("Access-Control-Allow-Methods", "GET, OPTIONS");
    res.headers.set("Access-Control-Allow-Headers", "*");
    res.headers.set("X-Frame-Options", "ALLOWALL");
    res.headers.set("Content-Security-Policy", "frame-ancestors *");

    return res;
  } catch (error) {
    console.error("Error proxying to TMDB:", error);
    return NextResponse.json(
      { error: "An error occurred while proxying the request to TMDB." },
      { status: 502 }
    );
  }
}

// For preflight (OPTIONS request)
export async function OPTIONS() {
  const res = new NextResponse(null, { status: 204 });
  res.headers.set("Access-Control-Allow-Origin", "*");
  res.headers.set("Access-Control-Allow-Methods", "GET, OPTIONS");
  res.headers.set("Access-Control-Allow-Headers", "*");
  res.headers.set("X-Frame-Options", "ALLOWALL");
  res.headers.set("Content-Security-Policy", "frame-ancestors *");
  return res;
}
