import { NextResponse, type NextRequest } from 'next/server';

const TMDB_BASE_URL = 'https://api.themoviedb.org/3';

// ✅ Proxy handler
export async function GET(
  request: NextRequest,
  { params }: { params: { slug: string[] } }
) {
  let { slug } = params;
  const { search, searchParams } = new URL(request.url);

  // 🔹 Remove `tmdb` prefix from slug (example: /api/tmdb/movie/... -> /movie/...)
  if (slug[0] === 'tmdb') {
    slug = slug.slice(1);
  }

  const tmdbPath = slug.join('/');

  // ✅ Require API Key in query
  const apiKey = searchParams.get('api_key');
  if (!apiKey) {
    return NextResponse.json(
      { error: 'api_key query parameter is required.' },
      { status: 400 }
    );
  }

  // 🔹 Construct TMDB URL
  const tmdbUrl = `${TMDB_BASE_URL}/${tmdbPath}${search}`;

  try {
    const tmdbResponse = await fetch(tmdbUrl, {
      headers: {
        'Content-Type': 'application/json',
      },
    });

    const data = await tmdbResponse.json();

    return NextResponse.json(data, {
      status: tmdbResponse.status,
    });
  } catch (error) {
    console.error('Error proxying to TMDB:', error);
    return NextResponse.json(
      { error: 'An error occurred while proxying the request to TMDB.' },
      { status: 502 }
    );
  }
}
