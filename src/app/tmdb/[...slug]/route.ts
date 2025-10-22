import { NextResponse, type NextRequest } from "next/server";

export const runtime = 'edge';

const TMDB_BASE_URL = "https://api.themoviedb.org/3";

export async function GET(
  request: NextRequest,
  { params }: { params: { slug: string[] } }
) {
  const { slug } = params;
  const { search } = new URL(request.url);

  const tmdbPath = slug.join("/");
  const tmdbUrl = `${TMDB_BASE_URL}/${tmdbPath}${search}`;

  try {
    const tmdbResponse = await fetch(tmdbUrl);
    const data = await tmdbResponse.json();
    return NextResponse.json(data, { status: tmdbResponse.status });
  } catch (error) {
    console.error("Error proxying to TMDB:", error);
    return NextResponse.json(
      { error: "An error occurred while proxying the request to TMDB." },
      { status: 502 }
    );
  }
}

export async function OPTIONS() {
  return new NextResponse(null, {
    status: 204,
    headers: {
      "Access-Control-Allow-Origin": "*",
      "Access-Control-Allow-Methods": "GET, OPTIONS",
      "Access-Control-Allow-Headers": "Content-Type",
    },
  });
}
