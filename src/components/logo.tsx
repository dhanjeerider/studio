import { Clapperboard } from 'lucide-react';
import { cn } from '@/lib/utils';

type LogoProps = {
  className?: string;
};

export function Logo({ className }: LogoProps) {
  return (
    <div className={cn("flex items-center gap-2", className)}>
      <Clapperboard className="h-6 w-6 text-primary" />
      <span className="text-lg font-bold tracking-tight text-foreground">Indie TMDB</span>
    </div>
  );
}
