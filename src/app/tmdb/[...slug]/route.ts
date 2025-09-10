import { NextResponse, type NextRequest } from 'next/server';

const TMDB_BASE_URL = 'https://api.themoviedb.org/3';

export async function GET(
  request: NextRequest,
  { params }: { params: { slug: string[] } }
) {
  const { slug } = params;
  const { search, searchParams } = new URL(request.url);

  const tmdbPath = slug.join('/');

  const apiKey = searchParams.get('api_key');
  if (!apiKey) {
    return NextResponse.json(
      { error: 'api_key query parameter is required.' },
      { status: 400 }
    );
  }

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
