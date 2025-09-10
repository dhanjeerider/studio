import { cn } from '@/lib/utils';

type CodeBlockProps = React.HTMLAttributes<HTMLElement>;

export function CodeBlock({ children, className, ...props }: CodeBlockProps) {
  return (
    <pre className={cn("text-xs bg-muted p-4 rounded-lg", className)} {...props}>
      <code>{children}</code>
    </pre>
  );
}
