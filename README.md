# Knowledge Archive CMS

A full demo knowledge base / CMS built with Laravel 11, Inertia 2, Vue 3, and Tailwind 4.

I put this together as a proper "complete-feeling" public repo for my portfolio. The goal was not to overengineer it into a production SaaS, but to build something that feels real enough to demo actual architecture decisions, frontend polish, reusable admin workflows and content structure.

It doubles as a place for me to store useful programming notes and concepts I come across, while also acting as a showcase project for Laravel + Vue + CMS style work.

The main domain acts as a portfolio landing page, while the CMS itself is designed to run under a dedicated subdomain.

---

## Features

### Frontend docs experience
- Docs-style reading UI inspired by modern enterprise documentation sites
- Dark and light themes
- Shared central theme system
- Collapsible category sidebar with nested categories
- "On this page" heading navigation
- Live article search dropdown
- Attachment downloads
- Responsive layout with docs navigation + content rail

### Admin CMS
- Manual auth system
- Role-aware admin backend (didn;t really bother with UI too much here)
    - `admin` role with full content access
    - `viewer` role for safe demo logins
- Category + CRUD
- Rich text article editor using TipTap
- Shared reusable article form partial
- Tagging with create-on-type + suggestions
- Article ordering / priority
- Category ordering / priority
- Draft / published workflow
- Media library
- Reusable attachments
- File upload directly from article forms
- Global success / error toast messaging
- Dark and light admin themes

### Portfolio root page
- Separate Vue-powered landing page
- Tailwind styling shared with the CMS repo
- Interactive particle background using `@tsparticles/vue3`
- Clean separation from CMS routes while still living in the same Laravel codebase

---

## Tech Stack

- Laravel 11
- PHP 8+
- Inertia.js 2
- Vue 3
- Tailwind CSS 4
- TipTap editor
- SQLite (default demo setup)
- Vite
- tsParticles

---

## Demo Account

Safe demo account for exploring the backend UI without edit permissions.

```text
Email: viewer@example.com
Password: password
```

---

## Intentional Tradeoffs

This repo is designed as a proof of concept and architecture showcase.

That means some production-grade concerns are intentionally lightweight:

* simple auth flow
* no advanced user management yet
* no comments system yet
* no revision history
* no granular permissions beyond roles
* no analytics
* no article versioning

That is by design.

The point here was to demonstrate strong foundations and clear extension paths rather than spend weeks building every enterprise edge case.

---

## Future Improvements

Things I may add later:

* full user management
* comments per article
* lightweight internal chatroom / websocket playground
* article revision history
* usage analytics
* role permissions beyond viewer/admin
* syntax-highlighted code blocks with copy buttons
* article reactions / feedback
