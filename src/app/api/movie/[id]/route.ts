import { NextResponse } from 'next/server';
import { mockMovieData } from '@/lib/mock-data';

export async function GET(
  request: Request,
  { params }: { params: { id: string } }
) {
  const { id } = params;

  if (!id) {
    return NextResponse.json({ error: 'Movie ID is required' }, { status: 400 });
  }

  // In a real application, you would fetch this from your database.
  // We're returning mock data and adding the requested ID.
  const movieData = { ...mockMovieData, id: parseInt(id) };

  return NextResponse.json(movieData);
}
