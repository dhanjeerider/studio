'use client';

import { useFormState, useFormStatus } from 'react-dom';
import { cloneAndSummarize, type FormState } from './actions';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Separator } from '@/components/ui/separator';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Terminal } from 'lucide-react';

function SubmitButton() {
  const { pending } = useFormStatus();
  return (
    <Button type="submit" disabled={pending}>
      {pending ? 'Cloning...' : 'Clone Data'}
    </Button>
  );
}

export default function ManualClonePage() {
  const initialState: FormState = {
    message: '',
    data: null,
    summary: null,
  };
  const [state, dispatch] = useFormState(cloneAndSummarize, initialState);

  return (
    <div className="grid gap-8 lg:grid-cols-2">
      <Card>
        <CardHeader>
          <CardTitle>Manual Data Clone</CardTitle>
          <CardDescription>
            Enter a TMDB ID and select the type to clone the data.
          </CardDescription>
        </CardHeader>
        <CardContent>
          <form action={dispatch} className="space-y-6">
            <div className="space-y-2">
              <Label htmlFor="type">Type</Label>
              <Select name="type" defaultValue="movie" required>
                <SelectTrigger id="type" className="w-full">
                  <SelectValue placeholder="Select a type" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="movie">Movie</SelectItem>
                  <SelectItem value="tv">TV Show</SelectItem>
                </SelectContent>
              </Select>
            </div>
            <div className="space-y-2">
              <Label htmlFor="id">TMDB ID</Label>
              <Input
                id="id"
                name="id"
                type="number"
                placeholder="e.g., 609681"
                required
              />
            </div>
            <SubmitButton />
          </form>
        </CardContent>
      </Card>

      <div className="space-y-6">
        {state.summary && (
          <Alert>
            <Terminal className="h-4 w-4" />
            <AlertTitle>AI Summary</AlertTitle>
            <AlertDescription>{state.summary}</AlertDescription>
          </Alert>
        )}
        
        {state.data && (
          <Card className="max-h-[600px] overflow-hidden flex flex-col">
            <CardHeader>
              <CardTitle>Cloned JSON Data</CardTitle>
              <CardDescription>
                Raw JSON response from the simulated API call.
              </CardDescription>
            </CardHeader>
            <CardContent className="flex-grow overflow-auto">
              <pre className="text-xs bg-muted p-4 rounded-lg">
                <code>{JSON.stringify(state.data, null, 2)}</code>
              </pre>
            </CardContent>
          </Card>
        )}
      </div>
    </div>
  );
}
