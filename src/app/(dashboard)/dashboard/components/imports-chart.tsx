"use client"

import { Bar, BarChart, CartesianGrid, XAxis, YAxis } from "recharts"
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/components/ui/chart"

const chartData = [
  { month: "January", movies: 186, shows: 80 },
  { month: "February", movies: 305, shows: 200 },
  { month: "March", movies: 237, shows: 120 },
  { month: "April", movies: 73, shows: 190 },
  { month: "May", movies: 209, shows: 130 },
  { month: "June", movies: 214, shows: 140 },
]

const chartConfig = {
  movies: {
    label: "Movies",
    color: "hsl(var(--chart-1))",
  },
  shows: {
    label: "TV Shows",
    color: "hsl(var(--chart-2))",
  },
}

export function ImportsChart() {
  return (
    <Card>
      <CardHeader>
        <CardTitle>Import Overview</CardTitle>
        <CardDescription>January - June 2024</CardDescription>
      </CardHeader>
      <CardContent>
        <ChartContainer config={chartConfig} className="h-[300px] w-full">
          <BarChart data={chartData} accessibilityLayer>
            <CartesianGrid vertical={false} />
            <XAxis
              dataKey="month"
              tickLine={false}
              tickMargin={10}
              axisLine={false}
              tickFormatter={(value) => value.slice(0, 3)}
            />
            <YAxis />
            <ChartTooltip content={<ChartTooltipContent />} />
            <Bar dataKey="movies" fill="var(--color-movies)" radius={4} />
            <Bar dataKey="shows" fill="var(--color-shows)" radius={4} />
          </BarChart>
        </ChartContainer>
      </CardContent>
    </Card>
  )
}
