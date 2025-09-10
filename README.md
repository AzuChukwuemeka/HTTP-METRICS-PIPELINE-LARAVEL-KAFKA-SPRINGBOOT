Realtime Web Metrics

Realtime Web Metrics is a full-stack solution for collecting, processing, and analyzing website traffic and HTTP events in real time. It leverages modern technologies to provide a scalable pipeline for web analytics.

Features

Real-time HTTP/web analytics: Track requests, response times, errors, and user interactions as they happen.

Event streaming: Powered by Kafka Streams for high-throughput, low-latency processing.

Microservices architecture: Backend with Laravel, processing services with Spring Boot.

Extensible: Easily add new metrics or processing pipelines.

Tech Stack

Backend: Laravel (API, event collection)

Streaming: Kafka Streams (real-time event processing)

Processing/Analytics: Spring Boot (aggregation, metrics computation)

Database/Storage: PostgreSQL

Architecture Overview

Laravel collects HTTP events and sends them to Kafka.

Kafka Streams handles real-time processing and transformation of events.

Spring Boot services aggregate metrics and provide analytics endpoints or dashboards.
