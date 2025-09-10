'use server';

import { z } from 'zod';
import { summarizeClonedData } from '@/ai/flows/summarize-cloned-data';
import { mockMovieData, mockTvData } from '@/lib/mock-data';

const CloneSchema = z.object({
  id: z.coerce.number().min(1, 'Please enter a valid ID.'),
  type: z.enum(['movie', 'tv']),
});

export type FormState = {
  message: string;
  data: any | null;
  summary: string | null;
};

export async function cloneAndSummarize(prevState: FormState, formData: FormData): Promise<FormState> {
  const validatedFields = CloneSchema.safeParse({
    id: formData.get('id'),
    type: formData.get('type'),
  });

  if (!validatedFields.success) {
    return {
      message: 'Invalid form data.',
      data: null,
      summary: null,
    };
  }
  
  const { id, type } = validatedFields.data;
  
  try {
    // In a real app, you'd fetch from TMDB API here
    // await fetch(`https://api.themoviedb.org/3/${type}/${id}?append_to_response=...`)
    const clonedData = type === 'movie' ? mockMovieData : mockTvData;

    // Add the requested ID to the mock data for realism
    const finalData = { ...clonedData, id };

    const summaryResult = await summarizeClonedData({
      data: JSON.stringify(finalData),
    });

    return {
      message: 'Successfully cloned and summarized data.',
      data: finalData,
      summary: summaryResult.summary,
    };
  } catch (error) {
    console.error(error);
    return {
      message: 'An error occurred while cloning data.',
      data: null,
      summary: null,
    };
  }
}
