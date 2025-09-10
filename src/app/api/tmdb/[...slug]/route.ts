import { NextResponse, type NextRequest } from 'next/server';

const TMDB_BASE_URL = 'https://api.themoviedb.org/3';

export async function GET(
  request: NextRequest,
  { params }: { params: { slug: string[] } }
) {
  const tmdbApiKey = process.env.TMDB_API_KEY;

  if (!tmdbApiKey) {
    return NextResponse.json(
      { error: 'TMDB_API_KEY is not configured in environment variables.' },
      { status: 500 }
    );
  }

  const { slug } = params;
  const { search } = new URL(request.url);
  const tmdbPath = slug.join('/');
  
  const tmdbUrl = `${TMDB_BASE_URL}/${tmdbPath}${search}`;

  try {
    const tmdbResponse = await fetch(tmdbUrl, {
      headers: {
        'Authorization': `Bearer ${tmdbApiKey}`,
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
