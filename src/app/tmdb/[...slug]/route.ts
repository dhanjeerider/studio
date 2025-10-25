import { NextResponse, type NextRequest } from "next/server";
export const runtime = 'edge';
const TMDB_BASE_URL = "https://api.themoviedb.org/3";
const TMDB_API_KEY = "7bffed716d50c95ed1c4790cfab4866a"; // Hardcoded API key

export async function GET(
  request: NextRequest,
  { params }: { params: { slug: string[] } }
) {
  const { slug } = params;
  const url = new URL(request.url);
  
  // Remove api_key from incoming params to avoid duplicates
  const searchParams = new URLSearchParams(url.search);
  searchParams.delete('api_key');
  const search = searchParams.toString();

  const tmdbPath = slug.join("/");

  // Append the API key automatically
  const separator = search ? "&" : "?";
  const tmdbUrl = `${TMDB_BASE_URL}/${tmdbPath}${search ? '?' + search : ''}${separator}api_key=${TMDB_API_KEY}`;

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
