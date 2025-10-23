import type {Metadata} from 'next';
import './globals.css';
import { Inter } from 'next/font/google';

const inter = Inter({ subsets: ['latin'] });

export const metadata: Metadata = {
  title: 'Indie TMDB',
  description: 'Your personal clone of The Movie Database API.',
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" className="dark" suppressHydrationWarning={true}>
      <body className={`${inter.className} antialiased`}>
        {children}
      </body>
    </html>
  );
}
