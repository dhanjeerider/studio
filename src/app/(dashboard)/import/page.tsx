"use client";

import { useState, useEffect, useRef } from 'react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Progress } from '@/components/ui/progress';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { Play, Square } from 'lucide-react';

interface LogEntry {
  timestamp: string;
  message: string;
  id: number;
}

export default function AutomatedImportPage() {
  const [isRunning, setIsRunning] = useState(false);
  const [progress, setProgress] = useState(0);
  const [currentId, setCurrentId] = useState(1430913);
  const [logs, setLogs] = useState<LogEntry[]>([]);
  const intervalRef = useRef<NodeJS.Timeout | null>(null);

  const addLog = (message: string) => {
    setLogs(prev => [{ timestamp: new Date().toLocaleTimeString(), message, id: Date.now() }, ...prev].slice(0, 100));
  };

  useEffect(() => {
    if (isRunning) {
      intervalRef.current = setInterval(() => {
        setProgress(prev => (prev >= 100 ? 0 : prev + Math.random() * 5));
        setCurrentId(prev => prev + 1);
        addLog(`Successfully cloned movie ID: ${currentId + 1}.`);
      }, 500);
    } else {
      if (intervalRef.current) {
        clearInterval(intervalRef.current);
      }
    }
    return () => {
      if (intervalRef.current) {
        clearInterval(intervalRef.current);
      }
    };
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [isRunning, currentId]);

  const handleToggle = () => {
    if (isRunning) {
      addLog('Automated import process stopped by user.');
    } else {
      addLog('Automated import process started.');
    }
    setIsRunning(!isRunning);
  };

  return (
    <div className="space-y-8">
      <Card>
        <CardHeader>
          <CardTitle>Continuous Data Import</CardTitle>
          <CardDescription>
            Manage the automated process that clones TMDB data sequentially.
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="flex items-center justify-between p-4 border rounded-lg">
            <div>
              <h3 className="font-semibold">Import Status: {isRunning ? 'Running' : 'Stopped'}</h3>
              <p className="text-sm text-muted-foreground">
                {isRunning ? `Currently processing movie ID: ${currentId}` : 'Ready to start import.'}
              </p>
            </div>
            <Button onClick={handleToggle} variant={isRunning ? 'destructive' : 'default'} size="lg">
              {isRunning ? <Square className="mr-2 h-4 w-4" /> : <Play className="mr-2 h-4 w-4" />}
              {isRunning ? 'Stop Import' : 'Start Import'}
            </Button>
          </div>
          {isRunning && (
            <div className="space-y-2">
              <Label>Current Batch Progress</Label>
              <Progress value={progress} />
            </div>
          )}
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Import Logs</CardTitle>
          <CardDescription>Real-time log of the import process.</CardDescription>
        </CardHeader>
        <CardContent>
          <div className="h-[400px] overflow-y-auto border rounded-md p-2 bg-muted/50">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead className="w-[100px]">Timestamp</TableHead>
                  <TableHead>Message</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {logs.map((log) => (
                  <TableRow key={log.id}>
                    <TableCell className="font-mono text-xs">{log.timestamp}</TableCell>
                    <TableCell className="font-mono text-xs">{log.message}</TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}
