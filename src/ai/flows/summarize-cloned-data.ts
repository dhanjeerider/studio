'use server';

/**
 * @fileOverview Summarizes the cloned TMDB data using AI.
 *
 * - summarizeClonedData - A function that summarizes the cloned TMDB data.
 * - SummarizeClonedDataInput - The input type for the summarizeClonedData function.
 * - SummarizeClonedDataOutput - The return type for the summarizeClonedData function.
 */

import {ai} from '@/ai/genkit';
import {z} from 'genkit';

const SummarizeClonedDataInputSchema = z.object({
  data: z.string().describe('The cloned TMDB data in JSON format.'),
});
export type SummarizeClonedDataInput = z.infer<typeof SummarizeClonedDataInputSchema>;

const SummarizeClonedDataOutputSchema = z.object({
  summary: z.string().describe('A short summary of the TMDB data.'),
});
export type SummarizeClonedDataOutput = z.infer<typeof SummarizeClonedDataOutputSchema>;

export async function summarizeClonedData(input: SummarizeClonedDataInput): Promise<SummarizeClonedDataOutput> {
  return summarizeClonedDataFlow(input);
}

const summarizeClonedDataPrompt = ai.definePrompt({
  name: 'summarizeClonedDataPrompt',
  input: {schema: SummarizeClonedDataInputSchema},
  output: {schema: SummarizeClonedDataOutputSchema},
  prompt: `Summarize the following TMDB data in a concise paragraph:\n\n{{{data}}}`,
});

const summarizeClonedDataFlow = ai.defineFlow(
  {
    name: 'summarizeClonedDataFlow',
    inputSchema: SummarizeClonedDataInputSchema,
    outputSchema: SummarizeClonedDataOutputSchema,
  },
  async input => {
    const {output} = await summarizeClonedDataPrompt(input);
    return output!;
  }
);
