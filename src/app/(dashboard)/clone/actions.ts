'use server';

import { z } from 'zod';
import { summarizeClonedData } from '@/ai/flows/summarize-cloned-data';

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
    const baseUrl = process.env.NEXT_PUBLIC_APP_URL || 'http://localhost:9002';
    const res = await fetch(`${baseUrl}/api/tmdb/${type}/${id}`);
    
    if (!res.ok) {
        const errorData = await res.json();
        console.error('TMDB API Error:', errorData);
        return {
            message: `Failed to clone data from TMDB: ${errorData.status_message || res.statusText}`,
            data: null,
            summary: null,
        };
    }

    const clonedData = await res.json();

    const summaryResult = await summarizeClonedData({
      data: JSON.stringify(clonedData),
    });

    return {
      message: 'Successfully cloned and summarized data.',
      data: clonedData,
      summary: summaryResult.summary,
    };
  } catch (error) {
    console.error(error);
    const errorMessage = error instanceof Error ? error.message : 'An unknown error occurred.';
    return {
      message: `An error occurred while cloning data: ${errorMessage}`,
      data: null,
      summary: null,
    };
  }
}
