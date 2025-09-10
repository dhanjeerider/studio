"use client";

import { useState, useEffect } from "react";
import { Copy, Check } from "lucide-react";
import { cn } from "@/lib/utils";

type CodeBlockProps = {
  children: string;
  className?: string;
};

export function CodeBlock({ children, className }: CodeBlockProps) {
  const [hasCopied, setHasCopied] = useState(false);
  const [baseUrl, setBaseUrl] = useState("");

  useEffect(() => {
    if (typeof window !== "undefined") {
      setBaseUrl(window.location.origin);
    }
  }, []);

  const fullUrl = `${baseUrl}/tmdb${children}`;
  const isLink = children.startsWith("/");

  const handleCopy = () => {
    navigator.clipboard.writeText(isLink ? fullUrl : children);
    setHasCopied(true);
    setTimeout(() => setHasCopied(false), 2000);
  };

  return (
    <div
      className={cn(
        "relative flex items-center justify-between gap-4 rounded-lg bg-muted/50 p-3 text-sm font-mono",
        className
      )}
    >
      {isLink ? (
        <a
          href={fullUrl}
          target="_blank"
          rel="noopener noreferrer"
          className="truncate text-foreground hover:underline"
          title={fullUrl}
        >
          {children}
        </a>
      ) : (
        <code className="truncate text-foreground">{children}</code>
      )}
      <button
        onClick={handleCopy}
        className="flex-shrink-0 p-1 text-muted-foreground transition-colors hover:text-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 focus:ring-offset-background rounded-md"
        aria-label="Copy to clipboard"
      >
        {hasCopied ? (
          <Check className="h-4 w-4 text-green-500" />
        ) : (
          <Copy className="h-4 w-4" />
        )}
      </button>
    </div>
  );
}
