from reportlab.lib.pagesizes import letter
from reportlab.lib.units import inch
from reportlab.pdfgen import canvas
from reportlab.lib import colors
from reportlab.pdfbase.pdfmetrics import stringWidth

OUTPUT_PATH = r"c:\xampp\htdocs\team-hifsa-skilset\output\pdf\team-hifsa-skillset-one-page-summary.pdf"

TITLE = "Team Hifsa Skillset - App Summary"

sections = [
    (
        "What it is",
        [
            "A Laravel 10 based e-learning application for publishing courses, lessons, and quizzes, and tracking learner progress.",
            "It includes user, instructor, and admin areas plus enrollment, payments, and queue-backed bulk lesson import capabilities.",
        ],
    ),
    (
        "Who it's for",
        [
            "Primary persona: training business admins and instructors who manage course content and learner activity.",
            "Secondary users: learners taking courses, completing lessons/quizzes, and managing payments/profile/support.",
        ],
    ),
    (
        "What it does",
        [
            "Course catalog and lesson delivery with categories and course detail pages.",
            "Enrollment flows with lesson completion/incompletion and per-lesson notes.",
            "Quiz authoring and participation with results and certificate views.",
            "Multi-role auth and dashboards (admin, instructor, user), including KYC and profile/security flows.",
            "Payment/deposit integrations with multiple gateways (for example Stripe, Razorpay, CoinGate).",
            "Support ticketing and notification systems across user/instructor/admin panels.",
            "Bulk lesson import job that can pull YouTube video metadata/comments into lessons via queue workers.",
        ],
    ),
    (
        "How it works (repo-evidenced architecture)",
        [
            "Request flow: repository root index.php boots application/bootstrap/app.php and Laravel HTTP Kernel.",
            "Routing: RouteServiceProvider maps web, user, instructor, admin, ipn, and api route files to namespaced controllers.",
            "Core layers: controllers + middleware + Eloquent models (Course/Lesson/Quiz/Enroll/Deposit/etc.) over relational DB migrations.",
            "Async processing: Laravel queues plus custom queue:run-worker command and public/queue_worker.php trigger for shared hosting.",
            "Integrations: service packages configured through environment variables (payments, Zoom, Twilio, Vonage, Socialite).",
            "Not found in repo: which external providers are enabled in the live environment (depends on .env).",
        ],
    ),
    (
        "How to run (minimal)",
        [
            "1. cd application",
            "2. composer install",
            "3. copy .env.example to .env, then run php artisan key:generate",
            "4. set DB credentials in .env and run php artisan migrate",
            "5. npm install && npm run build (or npm run dev)",
            "6. php artisan serve",
            "Optional when queues are used: php artisan queue:work (or queue:run-worker for shared-hosting patterns).",
        ],
    ),
]


def wrap_text(text, font_name, font_size, max_width):
    words = text.split()
    lines = []
    current = ""
    for word in words:
        trial = f"{current} {word}".strip()
        if stringWidth(trial, font_name, font_size) <= max_width:
            current = trial
        else:
            if current:
                lines.append(current)
            current = word
    if current:
        lines.append(current)
    return lines


c = canvas.Canvas(OUTPUT_PATH, pagesize=letter)
width, height = letter

margin = 0.55 * inch
content_width = width - (2 * margin)
y = height - margin

# Header
c.setFillColor(colors.HexColor("#0f172a"))
c.setFont("Helvetica-Bold", 18)
c.drawString(margin, y, TITLE)
y -= 0.24 * inch

c.setFont("Helvetica", 8.5)
c.setFillColor(colors.HexColor("#475569"))
c.drawString(margin, y, "Evidence source: repository files in this workspace (README, routes, config, jobs, models).")
y -= 0.2 * inch

c.setStrokeColor(colors.HexColor("#cbd5e1"))
c.setLineWidth(0.8)
c.line(margin, y, width - margin, y)
y -= 0.16 * inch

heading_size = 11.3
body_size = 9.2
line_gap = 1.18
bullet_indent = 11
sub_indent = 6

for heading, items in sections:
    c.setFillColor(colors.HexColor("#0b3b69"))
    c.setFont("Helvetica-Bold", heading_size)
    c.drawString(margin, y, heading)
    y -= body_size * 1.08

    c.setFillColor(colors.HexColor("#111827"))
    c.setFont("Helvetica", body_size)
    for item in items:
        wrapped = wrap_text(item, "Helvetica", body_size, content_width - bullet_indent - sub_indent)
        for i, line in enumerate(wrapped):
            prefix = "- " if i == 0 else "  "
            c.drawString(margin + sub_indent, y, prefix + line)
            y -= body_size * line_gap
    y -= body_size * 0.28

c.save()
print(OUTPUT_PATH)
