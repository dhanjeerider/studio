import { cn } from '@/lib/utils';

type CodeBlockProps = React.HTMLAttributes<HTMLElement>;

export function CodeBlock({ children, className, ...props }: CodeBlockProps) {
  return (
    <pre className={cn("text-xs bg-gray-700 p-4 rounded-lg overflow-x-auto", className)} {...props}>
      <code>{children}</code>
    </pre>
  );
}
