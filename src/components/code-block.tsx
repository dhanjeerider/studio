import { FC } from 'react';

interface CodeBlockProps {
  children: React.ReactNode;
}

export const CodeBlock: FC<CodeBlockProps> = ({ children }) => {
  return (
    <div className="rounded-md bg-gray-900 p-4 text-sm text-gray-100">
      <pre>
        <code>{children}</code>
      </pre>
    </div>
  );
};
