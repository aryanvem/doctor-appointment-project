# 🩺 DoctorsApp

hey so this is a doctor appointment booking thing i built for a PHP assignment. it's basically a clone of [this page](https://doctorsapp.in/doctors/dr-kapil-shukla/8108716370) but made from scratch in Laravel. turned out pretty decent ngl

---

## what does it actually do?

- you visit a doctor's page, pick a clinic, choose a date
- slots pop up (green = available, grey = already booked) via AJAX so no page reload
- click a slot → hit Continue
- if you're not logged in it sends you to login first
- login is just email + OTP, no password nonsense
- OTP lands in your email (or shows on screen if mail isn't set up)
- confirm the appointment → done
- you get a pretty confirmation email with all the details
- there's also a "My Appointments" page to see all your bookings

honestly that's it. pretty straightforward once it's running lol

---

## tech stack

- **Laravel 11** — the main framework
- **MySQL** — database
- **Bootstrap 5** — frontend styling
- **Blade** — templating
- **AJAX** — for loading slots without refreshing the page
- **SMTP (Gmail)** — for sending OTP + confirmation emails

---

## folder structure (the important bits)

```
app/
  Http/Controllers/
    AuthController.php          ← handles login, OTP send/verify, logout
    DoctorController.php        ← doctor page + slots API
    AppointmentController.php   ← booking flow start to finish
  Mail/
    OtpMail.php                 ← the OTP email
    AppointmentConfirmationMail.php  ← the fancy confirmation email
  Models/
    Doctor, Clinic, Slot, FeesDetail, User, Appointment

database/
  migrations/   ← 6 tables total
  seeders/      ← seeds Dr. Kapil Shukla with clinics + slots

resources/views/
  layouts/app.blade.php         ← master layout with navbar
  doctor/show.blade.php         ← the main booking page
  auth/login.blade.php          ← animated login (has a walking character lol)
  auth/verify_otp.blade.php     ← OTP input with 6 boxes + countdown
  appointments/confirm.blade.php
  appointments/success.blade.php
  appointments/index.blade.php  ← my appointments list
  emails/
    otp.blade.php
    appointment_confirmation.blade.php  ← premium styled email
```

---

## database tables

just 6 tables, nothing crazy:

| table | what's in it |
|---|---|
| `doctors` | name, slug, phone, qualification, specialization etc |
| `clinics` | belongs to a doctor, has address + contact |
| `fees_details` | first visit fee, follow up fee per clinic |
| `slots` | time slots per doctor+clinic, can be day-specific or all days |
| `users` | email, name, OTP stuff — no passwords |
| `appointments` | ties everything together, has a booking ref |

---

## setting it up

> this took me a while to figure out on Windows so here's the clearest version i can write

**1. get a fresh Laravel project going**
```bash
composer create-project laravel/laravel doctorsapp
cd doctorsapp
```

**2. copy the project files in** (app, database, resources, routes folders)

**3. set up your .env**
```env
DB_CONNECTION=mysql
DB_DATABASE=doctor_appointment
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

**4. create the database** (in MySQL Workbench or wherever)
```sql
CREATE DATABASE doctor_appointment;
```

**5. migrate + seed**
```bash
php artisan migrate
php artisan db:seed
```

**6. start the server**
```bash
php artisan serve
```

**7. open this in browser**
```
http://localhost:8000/doctors/dr-kapil-shukla/8108716370
```

---

## email setup (optional but nice)

if you want actual emails to work, add this to `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@doctorsapp.in
MAIL_FROM_NAME="DoctorsApp"
```

> if you skip this, no worries — the OTP just shows up in a yellow banner on screen so you can still test everything. the confirmation email just silently fails but the booking still works fine

---

## pages / routes

| url | what it is |
|---|---|
| `/doctors/dr-kapil-shukla/8108716370` | the main booking page |
| `/login` | email + name login |
| `/login/verify` | OTP verification |
| `/my-appointments` | see all your bookings |
| `/api/slots?doctor_id=1&clinic_id=1&date=2024-01-25` | AJAX endpoint for slots |

---

## a few things worth knowing

- the login page has an animated walking delivery character (repurposed from a Figma design, looks cool)
- OTP expires in 10 minutes
- booked slots show as grey so nobody double-books the same slot
- confirmation email is properly styled — has all the details, a reminders box, clinic contact info and a CTA button
- you can add more doctors just by adding rows to the DB + seeding their clinics and slots

---

## if something breaks

most common issues i ran into:

- **404 on the doctor page** → routes/web.php probably didn't copy over
- **slots not loading** → migrations didn't run, do `php artisan migrate:fresh --seed`
- **OTP column missing** → you're on SQLite not MySQL, fix `DB_CONNECTION=mysql` in `.env`
- **artisan not found** → you're in the wrong folder or it's a fresh Laravel without the project files copied in

---

*built for PHP assignment — Laravel 11 + MySQL + Bootstrap 5*  
*windows setup was a journey but we got there* 😅