# Product Requirements Document (PRD)
## INSPIN.com - Sports Betting Analysis Platform

---

### 1. Product Overview

**Product Name:** INSPIN.com  
**Type:** Sports Betting Analysis & Handicapping Platform  
**Current Stage:** MVP Development  
**Target Launch:** Q2 2026  

INSPIN.com is a sports betting analysis platform that provides expert picks, betting consensus data, live odds comparison, and simulation model insights for NFL, NBA, MLB, NHL, and NCAA sports. The platform operates on a freemium model with free picks available publicly and premium picks behind a subscription paywall.

---

### 2. Problem Statement

Sports bettors lack access to data-driven, simulation-backed picks and real-time consensus data. Most handicappers provide picks without transparency on win rates, public betting splits, or sharp money movement. INSPIN solves this by offering a simulation model that has tracked +150 units over 3 years, combined with public betting consensus data and expert analysis.

---

### 3. Target Users

| User Type | Description | Needs |
|-----------|-------------|-------|
| **Free User** | Casual bettor browsing free content | Free picks, articles, basic consensus data |
| **Member** | Subscribed user ($99.99/mo) | Full picks access, premium articles, all consensus data |
| **VIP Member** | High-value subscriber | Priority support, exclusive picks, early access |
| **Admin** | Platform operator | Content management, user management, analytics |

---

### 4. Core Features

#### 4.1 Public Website
| Feature | Description | Priority | Status |
|---------|-------------|----------|--------|
| Homepage | Hero, latest picks, consensus preview, packages, sports grid | P0 | ✅ Complete |
| Articles/Blog | Sports betting articles with sport/category filters | P0 | ✅ Complete |
| Article Detail | Full article view with related articles | P0 | ✅ Complete |
| Top Consensus | Public betting splits with percentages | P0 | ✅ Complete |
| Live Odds | Odds comparison table | P1 | ✅ Complete |
| Trends | Betting trends overview | P1 | ✅ Complete |
| Join Page | Package pricing cards with CTA | P0 | ✅ Complete |
| About Us | Company info and mission | P2 | ✅ Complete |
| Reviews | User testimonials | P2 | ✅ Complete |
| Betting Tools | Calculators (coming soon) | P3 | 🔄 Placeholder |
| Buy Bitcoin | Crypto betting guide | P3 | ✅ Complete |

#### 4.2 Authentication & Membership
| Feature | Description | Priority | Status |
|---------|-------------|----------|--------|
| Sign In | Email/password login with remember me | P0 | ✅ Complete |
| Sign Up | Registration with name, email, phone, password | P0 | ✅ Complete |
| Forgot Password | Email-based password reset | P0 | ✅ Complete |
| User Profile | Account details, role, support tickets | P1 | ✅ Complete |
| Premium Content Gate | Lock premium articles for non-subscribers | P0 | ✅ Complete |
| Subscription Middleware | Role-based access control | P0 | ✅ Complete |

#### 4.3 Admin Panel
| Feature | Description | Priority | Status |
|---------|-------------|----------|--------|
| Dashboard | Stats overview (tips, tickets, contests, articles) | P0 | ✅ Complete |
| Tips/Picks CRUD | Manage daily picks | P0 | ✅ Complete |
| Support Tickets CRUD | Manage customer tickets | P0 | ✅ Complete |
| Contests CRUD | Manage contests | P1 | ✅ Complete |
| Articles CRUD | Manage blog/articles | P0 | ✅ Complete |
| Users Management | Edit roles, passwords, delete users | P0 | ✅ Complete |

#### 4.4 Data Layer
| Feature | Description | Priority | Status |
|---------|-------------|----------|--------|
| Tips Model | Daily picks with dates, titles, groups | P0 | ✅ Complete |
| Articles Model | Blog posts with categories, sports, premium flag | P0 | ✅ Complete |
| BettingConsensus Model | Game odds, public/money percentages | P0 | ✅ Complete |
| Package Model | Subscription plans with pricing | P0 | ✅ Complete |
| SupportTicket Model | Customer support tickets | P1 | ✅ Complete |
| Contest Model | Contests/competitions | P1 | ✅ Complete |
| User Model | Auth with phone, role fields | P0 | ✅ Complete |

---

### 5. Tech Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| Framework | Laravel | 9.x |
| Language | PHP | 8.2+ |
| Frontend | Blade Templates + Inline CSS | - |
| Database | SQLite (dev) / MySQL 8 (prod) | - |
| Auth | Laravel Breeze-style custom auth | - |
| Server | PHP Built-in (dev) / Nginx (prod) | - |
| ORM | Eloquent | - |
| Migrations | Laravel Migrations | - |

---

### 6. Data Summary (Current)

| Table | Records | Source |
|-------|---------|--------|
| Tips/Picks | 1,895 | 1,888 real from legacy + 7 seeded |
| Articles | 15 | 5 real-ish + 10 seeded |
| Users | 9 | 1 admin + 2 real + 6 seeded |
| Betting Consensus | 12 | 4 real + 8 seeded |
| Packages | 3 | Seeded (Monthly/Quarterly/Annual) |
| Support Tickets | 20 | Seeded |
| Contests | 15 | Seeded |

---

### 7. Subscription Plans

| Plan | Price | Duration | Features |
|------|-------|----------|----------|
| Monthly | $99.99 | 30 days | All picks, consensus, trends, support |
| Quarterly | $249.99 | 90 days | All picks, consensus, trends, support, save $50 |
| Annual | $799.99 | 365 days | All picks, consensus, trends, support, priority, save $400 |

---

### 8. Remaining Work for Production

#### Phase 8 - Payment Integration
- [ ] Stripe payment gateway integration
- [ ] Subscription purchase flow
- [ ] Webhook handling for subscription events
- [ ] Invoice generation
- [ ] Trial period support

#### Phase 9 - Content Enhancement
- [ ] Full WordPress articles import (wp_posts → articles)
- [ ] Featured image upload for articles
- [ ] Rich text editor for article creation (TinyMCE/Quill)
- [ ] Article search and advanced filtering
- [ ] SEO meta tags per article

#### Phase 10 - Real-Time Data
- [ ] Live odds API integration (The Odds API / SportsRadar)
- [ ] Real-time consensus data feed
- [ ] Automated pick result grading
- [ ] Win/loss record tracking per sport

#### Phase 11 - User Experience
- [ ] Email notifications (welcome, password reset, picks alerts)
- [ ] Telegram integration for pick delivery
- [ ] SMS notifications for picks
- [ ] User pick history and tracking
- [ ] Bookmarked/favorite articles

#### Phase 12 - Admin Enhancements
- [ ] Analytics dashboard (revenue, user growth, pick performance)
- [ ] Bulk pick import/export
- [ ] Email broadcast to subscribers
- [ ] Content scheduling
- [ ] Role-based admin permissions

#### Phase 13 - Production Readiness
- [ ] MySQL production database setup
- [ ] Nginx + PHP-FPM configuration
- [ ] SSL certificate (Let's Encrypt)
- [ ] Environment configuration (.env.production)
- [ ] Queue worker setup (Redis)
- [ ] Backup strategy (automated DB backups)
- [ ] Monitoring (Sentry, UptimeRobot)
- [ ] CDN for static assets
- [ ] Rate limiting and security hardening
- [ ] GDPR compliance (cookie consent, data export)

---

### 9. Production Timeline

| Phase | Duration | Start | End | Deliverables |
|-------|----------|-------|-----|-------------|
| **Phase 8: Payments** | 2 weeks | Week 1 | Week 2 | Stripe integration, subscription flow, webhooks |
| **Phase 9: Content** | 1.5 weeks | Week 3 | Week 4 | Full article import, rich editor, SEO |
| **Phase 10: Real-Time** | 2 weeks | Week 5 | Week 6 | Live odds API, auto-grading, tracking |
| **Phase 11: UX** | 1.5 weeks | Week 7 | Week 8 | Email/SMS/Telegram, user features |
| **Phase 12: Admin** | 1 week | Week 9 | Week 9 | Analytics, bulk tools, permissions |
| **Phase 13: Production** | 1.5 weeks | Week 10 | Week 11 | Deployment, SSL, monitoring, security |
| **Testing & QA** | 1 week | Week 11 | Week 12 | Bug fixes, performance, load testing |
| **Launch** | - | Week 12 | Week 12 | Go live |

**Total Estimated Time: 12 weeks (~3 months)**

---

### 10. Success Metrics

| Metric | Target |
|--------|--------|
| Monthly Active Users | 5,000+ |
| Paid Subscribers | 200+ |
| Monthly Recurring Revenue | $20,000+ |
| Pick Win Rate | 55%+ |
| User Retention (30-day) | 70%+ |
| Page Load Time | < 2 seconds |
| Uptime | 99.9% |

---

### 11. Risks & Mitigations

| Risk | Impact | Mitigation |
|------|--------|------------|
| Payment gateway delays | High | Use Stripe (well-documented, fast integration) |
| Live odds API cost | Medium | Start with free tier, cache responses |
| Content quality | High | Editorial review process before publishing |
| User acquisition | High | SEO optimization, social media, affiliate program |
| Regulatory compliance | High | Legal review, age verification, responsible gambling notices |

---

### 12. Admin Access

**URL:** http://127.0.0.1:8000/login  
**Email:** admin@inspin.local  
**Password:** password123  

After login, navigate to Dashboard → Manage Articles / Manage Users / Manage Tips / Manage Tickets / Manage Contests.

---

*Document Version: 1.0*  
*Last Updated: April 3, 2026*  
*Status: MVP Complete - Production Phase Pending*
