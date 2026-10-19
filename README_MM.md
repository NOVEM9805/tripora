# Tripora — PHP / MySQL travel booking website

Screenshot ထဲက cream/forest-green/terracotta design ကို ထိန်းထားပြီး SHE Game Shop လို customer၊ auth၊ admin၊ config၊ includes folder တွေ ခွဲထားပါတယ်။ Website UI ကို မြန်မာ / English နှစ်မျိုး ပြောင်းသုံးနိုင်ပြီး ဒီ setup guide က မြန်မာလိုပါ။

## အရင် version မှ update လုပ်ရန်

1. လက်ရှိ project folder နဲ့ database ကို backup လုပ်ပါ။
2. ZIP အသစ်ထဲက tripora source files တွေကို လက်ရှိ project ထဲ copy / replace လုပ်ပါ။
3. ကိုယ့် `.env`၊ `public/uploads/`၊ `storage/private/` ကို ထိန်းထားပါ။ ZIP မှာ credentials / user uploads မပါပါ။
4. **phpMyAdmin မှာ လက်ရှိ Tripora database ကို ရွေးပြီး `database/upgrade_v2.sql`၊ ပြီးရင် `database/upgrade_v3.sql` ကို Import လုပ်ပါ။** V2 က chat / Myanmar catalogue ကို ထည့်ပြီး V3 က profile photo column နဲ့ password-change OTP type ကို ထည့်ပေးပါတယ်။ V2 လုပ်ပြီးသားဆို V3 ကို လုပ်ပါ။ **V3 လုပ်ပြီးသားဆို database/upgrade_v4.sql ကို ထပ် import လုပ်ပါ။** V4 က legacy gallery columns နဲ့ private email delivery history ကို ထည့်ပါတယ်။ **V4 လုပ်ပြီးသားဆို database/upgrade_v5.sql ကို Import လုပ်ပါ။** V5 က ပုံအရေအတွက် မကန့်သတ်သော gallery table ကို ထည့်ပြီး အရင်အပိုပုံများကို တစ်ကြိမ်သာ ကူးပေးပါတယ်။ Users၊ bookings၊ payments နဲ့ saved stays ကို မဖျက်ပါ။ ထပ် import လုပ်မိလည်း seed data မပွားအောင် စစ်ထားပါတယ်။ **ရှိပြီးသား database မှာ `database/tripora.sql` အပြည့်အစုံကို ပြန် import မလုပ်ပါနဲ့။**
5. အောက်က Gmail SMTP settings တွေကို ကိုယ့် `.env` မှာ ဖြည့်ပါ။ `MAIL_MODE` setting ကို မသုံးတော့ပါ။
6. Ctrl + F5 တစ်ကြိမ်လုပ်ပြီး JavaScript / CSS အသစ်ကို ယူပါ။ နောက်ပိုင်း Save လုပ်တဲ့အခါ page refresh မဖြစ်ပါ။
7. အရင် `app/` folder မလိုတော့ပါ။ Backup ရှိပြီးမှ လက်ရှိ install ထဲက အဟောင်းကို ဖယ်နိုင်ပါတယ်။

## XAMPP နဲ့ ဖွင့်နည်း

1. ZIP ဖြည်ပြီး `tripora` folder ကို `C:\xampp\htdocs\tripora` ထဲ ထည့်ပါ။ `index.php` က အဲဒီ folder အောက်မှာ တိုက်ရိုက်ရှိရပါမယ်။
2. XAMPP Control Panel မှာ Apache နဲ့ MySQL ကို Start လုပ်ပါ။ PHP 8.1+၊ PDO MySQL၊ Fileinfo နဲ့ OpenSSL လိုပါတယ်။
3. `http://localhost/phpmyadmin` ကို ဖွင့်ပါ။
4. Import မှာ `database/tripora.sql` ကို ထည့်ပါ။ SQL က `tripora` database ကို ဖန်တီးပြီး ရွေးပေးထားလို့ #1046 “No database selected” မဖြစ်အောင် ပြင်ထားပါတယ်။ Fresh install အတွက် တစ်ကြိမ်သာ import လုပ်ပါ။
5. `.env.example` ကို `.env` အဖြစ် copy လုပ်ပါ။ File name က `.env` ဖြစ်ရပါမယ်၊ `.env.txt` မဖြစ်ရပါ။ Default XAMPP မှာ DB_USER=root၊ DB_PASS=empty၊ DB_PORT=3306 ဖြစ်ပါတယ်။ သင့် settings နဲ့ ကွဲရင် ပြင်ပါ။
6. `http://localhost/tripora/admin/setup-admin.php` ဖွင့်ပြီး ကိုယ်ပိုင် admin name/email/password သတ်မှတ်ပါ။ Default admin password မပေးထားပါ။ Admin ဖန်တီးပြီးရင် setup ပိတ်သွားပါမယ်။
7. Website ကို `http://localhost/tripora/`၊ admin login ကို `http://localhost/tripora/admin/login.php` မှာ ဖွင့်ပါ။ Customer login က `auth/login.php`၊ site settings က `admin/settings.php` ပါ။ အရင် `index.php?page=...` bookmarks တွေကို page အသစ်ဆီ redirect လုပ်ပေးပါတယ်။

## ပါဝင်တာတွေ

- Home hero၊ search၊ country guides၊ destination details၊ hotel/room details။
- Countries 6 ခု၊ destinations 30 ခု၊ hotels 90 ခု၊ room types 180 ခု။ Destination တစ်ခုလျှင် hotels 3 ခုနဲ့ hotel တစ်ခုလျှင် room types 2 ခု။
- Register / email code verification / login / logout / password reset။
- Profile photo upload / replace / remove၊ profile edit dialog။
- Change password / Forgot password — OTP အရင်အတည်ပြုပြီးမှ New password form ပေါ်ခြင်း။
- Saved stays၊ My trips၊ booking details၊ completed booking reviews။
- Check-in/out၊ guests၊ room inventory availability ကို page refresh မဖြစ်ဘဲ စစ်ခြင်း။ One room per booking ဖြစ်ပါတယ်။
- Customer / Admin နှစ်ဖက် private chat၊ receipt dialog နဲ့ screenshot zoom။
- မြန်မာ / English language switcher၊ Myanmar destination 5 ခု။
- Price snapshot၊ promo discount၊ 24-hour unpaid hold၊ payment-proof submission၊ 48-hour admin review hold။
- Bank / KPay / Wave proof ပို့ခြင်း၊ admin က verify/reject လုပ်ခြင်း။ Live payment gateway မပါပါ။ Card information မကောက်ပါ။
- Cancellation၊ expired holds၊ refund_due / refunded status။ Refund ကို website အပြင်မှာ administrator က ကိုယ်တိုင်ပို့ပေးရပါတယ်။
- Admin countries / destinations / hotels / rooms / promotions CRUD၊ booking/payment management၊ customer access၊ review visibility၊ contact messages၊ site settings။
- Prepared queries၊ hashed passwords၊ CSRF၊ session rotation၊ login/code limits၊ image MIME/size validation နဲ့ protected receipt access။

## Booking flow

1. Customer register → verification code ထည့် → sign in။
2. Stay ကိုရွေး → dates/guests ရွေး → Check availability → guest name/phone ထည့် → Reserve this room။
3. Reservation က 24 နာရီအတွင်း payment proof ပို့ဖို့ hold လုပ်ထားပါတယ်။
4. Payment proof ပို့ပြီးရင် admin review အတွက် 48 နာရီ hold ပြောင်းပါတယ်။ Admin က Payments & refunds မှာ receipt ကြည့်ပြီး Verify / Reject လုပ်ပါ။
5. Verify လုပ်ရင် confirmed ဖြစ်ပါတယ်။ Check-out date ရောက်ပြီးမှ Admin > Bookings မှာ Complete လုပ်ပါ။ ပြီးမှ customer review ရေးနိုင်ပါတယ်။
6. Hold ကုန်ရင် expired ဖြစ်ပြီး room availability ပြန်လွတ်ပါတယ်။ ပို့ထားတဲ့ proof ရှိရင် refund_due ဖြစ်ပါတယ်။ Any request တိုင်းမှာ expiry cleanup လုပ်ပါတယ်။ Traffic မရှိချိန်မှာ request နောက်တစ်ခါလာမှ status ပြောင်းပေမယ့် availability query က expired hold ကို ချက်ချင်းဖယ်ထားပါတယ်။

## Gmail OTP — PHPMailer

PHPMailer ကို ZIP ထဲမှာ ပါပြီးသား ထည့်ထားပါတယ်။ OTP ကို register / password reset လုပ်သူရဲ့ email address ဆီ SMTP နဲ့ပို့ပါတယ်။ Outbox ထဲ code ရေးတဲ့ fallback မပါပါ။

ကိုယ့် Gmail မှာ 2-Step Verification ဖွင့်ပြီး App Password ဖန်တီးပါ။ Google လမ်းညွှန်: https://support.google.com/accounts/answer/185833

`.env` မှာ placeholder တွေကို ကိုယ့် values နဲ့ အစားထိုးပါ။

```ini
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_ENCRYPTION=tls
SMTP_USER=your-address@gmail.com
SMTP_PASS=your-new-app-password-without-spaces
SMTP_FROM=your-address@gmail.com
```

SMTP_HOST မှာ Gmail address မထည့်ပါနဲ့။ SMTP_USER က website ပိုင်ရှင်၏ ပို့မည့် Gmail address ဖြစ်ပြီး customer Gmail ကို ဒီနေရာမှာ မထည့်ရပါ။ SMTP_FROM ကို အလွတ်ထားလျှင် SMTP_USER ကို အလိုအလျောက် သုံးပါမည်။ သီးခြားထည့်လျှင် sender address တူရပါမည် သို့မဟုတ် ပို့ခွင့်ရှိသော alias ဖြစ်ရပါမည်။ SMTP_PASS က ပုံမှန် Gmail password အစား App Password ဖြစ်ရပါမည်။ Google က အုပ်စုခွဲပြသော spaces ပါလာလျှင် Gmail SMTP အတွက် ဖယ်ပေးထားပါသည်။ Internet / outbound SMTP connection နဲ့ PHP OpenSSL လိုပါတယ်။ ပို့မရရင် error ပြပြီး unsent code ကို database က ဖယ်ပေးပါတယ်။ Register / Forgot password နဲ့ စမ်းပြီး recipient ရဲ့ Inbox / Spam ကို စစ်ပါ။

PHPMailer TLS/auth SMTP ပို့ခြင်းကို test mail server နဲ့ စမ်းပြီးပါပြီ။ ကိုယ့် Gmail account ရဲ့ inbox delivery ကို settings ဖြည့်ပြီးမှ စမ်းရပါမယ်။

**ယခု OTP mail design** — Tripora forest-green header၊ cream code card၊ ရှင်းလင်းသော ၆ လုံးကုဒ်၊ ၁၀ မိနစ်သက်တမ်း၊ account email၊ verification / password reset / password change တောင်းဆိုမှု၊ UTC timestamp၊ security notice နဲ့ footer ပါသည့် HTML mail ဖြစ်ပါသည်။ Website မှာ ရွေးထားသော မြန်မာ / English နဲ့ ပို့ပြီး HTML မဖတ်နိုင်သော mail client အတွက် plain text ပါပါသည်။ External photo / tracking image မလိုပါ။ Code ကို select / copy လုပ်ပြီး website OTP အကွက်တွင် paste လုပ်ပါ။ Screenshot ထဲက Gmail smart card / Copy code button က Gmail app ပိုင် UI ဖြစ်သဖြင့် mail HTML မှ ထိန်းချုပ်ခြင်းမပြုနိုင်ပါ။ Google logo အစား Tripora brand ကို သုံးထားပါသည်။

**Customer OTP မရောက်လျှင်** — Register / Change password / Forgot password မှာ ပြထားသော error ကို အရင်စစ်ပါ။ ယခု SMTP sign-in failure၊ connection failure၊ server ယာယီငြင်းပယ်ခြင်းနဲ့ message rejection ကို ခွဲပြပါသည်။ Error ရှိလျှင် ပို့ပြီးပြီဟု မပြပါ၊ unsent token ကို ဖျက်ပြီး outbox fallback မလုပ်ပါ။ Wrong App Password ဖြစ်လျှင် အသစ်ဖန်တီးပြီး website ပိုင်ရှင်၏ `.env` ကို ပြင်ပါ။ Gmail login password ပြောင်းပြီးနောက် App Password အဟောင်းကို Google က ဖယ်ပေးနိုင်ပါသည်။

ပို့ပြီးပြီဟု ပြသော်လည်း မရောက်လျှင် recipient Gmail ၏ Spam / All Mail ကို စစ်ပြီး ပို့သူ Gmail ၏ Sent / delivery-failure mail ကို စစ်ပါ။ Sender ကိုယ်တိုင်ဆီ ရောက်ခြင်းက အခြား customer inbox ရောက်ကြောင်း အတည်မပြုပါ။ Customer account တွင် သိမ်းထားသည့် email ကို မှန်အောင်ထည့်ရပါမည်။ Forgot password က မရှိသော / inactive account ကို email မပို့ဘဲ အကောင့်ရှိမရှိ မဖော်ပြသော generic notice ပြပါသည်။ SMTP လက်ခံခြင်းက Gmail inbox ထဲ ရောက်ပြီးပြီဟု အာမခံခြင်းမဟုတ်ပါ။

Official guidance: https://support.google.com/mail/answer/185833 ၊ https://support.google.com/mail/answer/7015314 ။ ဒီ update အတွက် SQL upgrade အသစ် မလိုပါ။ ကိုယ့် `.env` ကို ZIP နဲ့ အစားမထိုးပါနှင့်။


## Save / Unsave

Login ဝင်ထားတဲ့ customer က heart ကိုနှိပ်ရင် လက်ရှိ page မှာပဲ background request နဲ့ save လုပ်ပါတယ်။ Saved page ကို မပို့ပါ၊ refresh မဖြစ်ပါ။ Save အောင်မြင်မှ heart အနီရောင်ပြည့်ပြီး ထပ်နှိပ်ရင် outline ပြန်ဖြစ်ပါတယ်။ Request fail ရင် state မပြောင်းဘဲ message ပြပါတယ်။

## Resend countdown၊ login ခွဲခြားမှုနဲ့ direct Edit

**Send a new code** ကို နှိပ်ရင် page refresh မဖြစ်ဘဲ background မှာ OTP ပို့ပါတယ်။ အောင်မြင်ရင် button ပျောက်ပြီး အဲဒီနေရာမှာ `01:00 → 00:00` countdown ပြပါတယ်။ ပြည့်ရင် button ပြန်ပေါ်ပါတယ်။ Registration၊ Forgot password နဲ့ Change password OTP အဆင့် သုံးခုလုံးမှာ ပါပါတယ်။ ပထမ code ပို့ထားချိန်ကလည်း cooldown ကို စထားပါတယ်။ Reload လုပ်မိရင် server ရဲ့ ကျန်ချိန်ကို ဆက်ပြပါတယ်။ Code အသစ်ပို့ပြီးရင် အဟောင်း OTP အကွက်တွေကို ရှင်းပေးပါတယ်။ Network / SMTP error မှာ message ပြပြီး retry လုပ်နိုင်ပါတယ်။ JavaScript မရှိရင် native form fallback က page navigation ရှိပါတယ်။

**Customer / Admin login** ကို သီးခြားခွဲထားပါတယ်။ `auth/login.php` က customer accounts ပဲ လက်ခံပြီး `admin/login.php` က administrator accounts ပဲ လက်ခံပါတယ်။ Form action ပြောင်းပို့ပြီးလည်း route / role check ကို ကျော်လို့မရပါ။ `auth/` folder မှာ registration၊ email verification၊ password reset နဲ့ shared password-change pages ပါတာကြောင့် auth folder ထဲက လုပ်ဆောင်ချက်အားလုံးကို customer သီးသန့်လို့ မယူဆရပါ။

**Admin Edit** — Countries၊ Destinations၊ Hotels၊ Rooms၊ Promotions စာရင်းတွေမှာ `Select to edit` အစား `Edit` ပါပါတယ်။ နှိပ်လိုက်ရင် သက်ဆိုင်ရာ record ကို background မှာယူပြီး edit dialog ထဲ တိုက်ရိုက်ဖွင့်ပါတယ်။ Add record ကိုနှိပ်ရင် အသစ်ဖန်တီးဖို့ fields အလွတ် ပြပါတယ်။ Edit dialog မှ Save record လုပ်တဲ့အခါ ပုံမှန် form submit / list reload ရှိပါတယ်။ Existing record image ကို ထိန်းချင်ရင် image field ကို အလွတ်ထားပါ။

ယခင် version မှ V2 / V3 database upgrade လုပ်ပြီးသားဆို ဒီ update အတွက် SQL အသစ် မလိုပါ။ `.env`၊ `public/uploads/` နဲ့ `storage/private/` ကို ထိန်းထားပြီး source files ပြောင်းပါ။ CSS / JavaScript အသစ်ရဖို့ Ctrl + F5 တစ်ကြိမ်လုပ်ပါ။

## Profile photo နဲ့ password OTP အသစ်

**Profile photo** — Profile → Edit profile → Profile photo မှာ JPG၊ PNG သို့မဟုတ် WebP ရွေး → Save profile လုပ်ပါ။ 5 MB အထိ ရပါတယ်။ Preview၊ ပုံအစားထိုးခြင်းနဲ့ Remove current photo ပါပါတယ်။ Profile နဲ့ header မှာ စက်ဝိုင်းပုံစံ ပြပါတယ်။ ပုံတွေကို `storage/private/` မှာ သိမ်းပြီး signed-in owner ရဲ့ avatar endpoint ကပဲ ပြပေးပါတယ်။ အဲဒီ folder ကို update လုပ်တဲ့အခါ မဖျက်ပါနဲ့။ Customer နဲ့ admin ကိုယ်ပိုင် profile နှစ်ခုလုံး သုံးနိုင်ပါတယ်။

**Change password** — Profile → Change password → Current password ထည့် → Send verification code → ကိုယ့် Gmail ထဲက OTP ၆ လုံးကို အကွက်များထဲ ထည့် → Verify code → အခုမှ New password / Confirm new password ပေါ်လာမယ် → Save new password လုပ်ပါ။ OTP မှန်ပြီးမှ password ပြောင်းလို့ရပြီး form ကို တိုက်ရိုက် POST လုပ်လည်း verification ကို ကျော်လို့မရပါ။ လက်ရှိ session ဆက်ဝင်ထားပေးပြီး အခြား signed-in sessions တွေကို ထွက်ပေးပါတယ်။

**Forgot password** — Forgot password → Email ထည့် → Send reset code → OTP သီးသန့်အဆင့် → Verify code → အခုမှ New password / Confirm new password → Save new password → Sign in လုပ်ပါ။ New password ကို OTP အဆင့်မှာ မဖော်ပြထားပါ။ Reset ပြီးရင် signed-in sessions အဟောင်းတွေကို invalidate လုပ်ပါတယ်။

OTP design က reference ပုံလို rounded boxes နဲ့ focus highlight ဖြစ်ပါတယ်။ လက်ရှိ OTP ၆ လုံးကို ထိန်းထားလို့ အကွက် ၆ ခု ပါပါတယ်။ ကုဒ်အပြည့်အစုံ paste / autofill လုပ်နိုင်ပြီး နံပါတ်ရိုက်ရင် နောက်အကွက်ကို ရွှေ့ပေးပါတယ်။ JavaScript မရှိလည်း အကွက်တစ်ခုချင်း ရိုက်ပြီး submit လုပ်နိုင်ပါတယ်။ Registration OTP မှာလည်း ဒီ design ကို သုံးထားပါတယ်။

OTP က ၁၀ မိနစ်အတွင်း အသုံးပြုရပြီး resend မတိုင်မီ ၁ မိနစ် စောင့်ရပါတယ်။ Incorrect attempts နဲ့ requests ကို ကန့်သတ်ထားပါတယ်။ OTP အတည်ပြုပြီးနောက် password အသစ်သတ်မှတ်ဖို့ ၁၀ မိနစ်ရပါတယ်။ အတည်ပြုပြီးသား code / password permission ကို ထပ်သုံးလို့မရပါ။ Permission ကို browser session၊ account နဲ့ password version တို့နဲ့ ချိတ်ထားပါတယ်။ OTP ကို PHPMailer နဲ့ Gmail SMTP ဆီပဲ ပို့ပါတယ်။ Outbox fallback မပါပါ။

## ယခင်ပြင်ထားသော လုပ်ဆောင်ချက် ၆ ခု

1. **Contact chat** — Customer က Contact မှာ message ပို့ပါ။ Admin က Messages မှာ conversation ကို ဖွင့်ပြီး ပြန်ဖြေနိုင်ပါတယ်။ Send / receive လုပ်တဲ့အခါ page refresh မဖြစ်ဘဲ 4 စက္ကန့်တစ်ကြိမ် message အသစ် စစ်ပါတယ်။ Admin inbox အလွတ်မှာလည်း conversation အသစ် ပေါ်လာပါတယ်။ Thread တစ်ခုကို ရွေးပြောင်းတဲ့အခါ ပုံမှန် page navigation ရှိပါတယ်။ Messages ကို database မှာ သိမ်းထားပြီး customer တစ်ယောက်ချင်းရဲ့ history ကို သူနဲ့ admin ပဲ ကြည့်နိုင်ပါတယ်။ Guest message အဟောင်းတွေကို verified customer ရဲ့ email နဲ့ တူရင် private thread ထဲ ချိတ်ပေးပါတယ်။ Browser ကို ပိတ်ထားချိန် notification service မပါပါ။
2. **Check availability** — Dates / guests ပြောင်းပြီး Check availability ကို နှိပ်ရင် room results ကိုပဲ background မှာ update လုပ်ပါတယ်။ ပြောင်းထားတဲ့ dates နဲ့ မစစ်ရသေးချိန်၊ request မအောင်မြင်ချိန်မှာ အဟောင်း booking form ကို ဖျောက်ထားပါတယ်။ Reserve လုပ်တဲ့အခါ server က availability / price ကို ထပ်စစ်ပါတယ်။
3. **Admin / Customer role** — Admin က public pages နဲ့ ကိုယ်ပိုင် profile ကို ကြည့်နိုင်ပေမယ့် customer Save၊ booking၊ payment submission၊ cancellation နဲ့ review ကို သုံးလို့မရပါ။ Admin management မှာ booking/payment ကို စီမံနိုင်ပါတယ်။ Customer flow စမ်းချင်ရင် သီးခြား customer account သုံးပါ။
4. **View receipt** — Payment reference၊ customer၊ hotel/room၊ stay dates၊ payment method / amount / transaction၊ review status နဲ့ screenshot ကို styled popup မှာ ပြပါတယ်။ Screenshot ကို zoom / fit လုပ်နိုင်ပါတယ်။ Receipt ကို ပိုင်ရှင် customer နဲ့ admin ပဲ ကြည့်နိုင်ပါတယ်။
5. **Myanmar** — Yangon၊ Mandalay၊ Bagan၊ Inle Lake၊ Ngapali ထည့်ထားပါတယ်။ Myanmar အတွက် fictional hotels 15 ခုနဲ့ room types 30 ခု ပါပါတယ်။ Prices အားလုံး USD ပါ။ Country currency description က MMK ဖြစ်ပေမယ့် currency conversion မလုပ်ပါ။
6. **Language** — Header မှာ မြန်မာ / EN ကို နှိပ်ပါ။ Customer နဲ့ Admin interface နှစ်ခုလုံး ပြောင်းပြီး ရွေးထားတာကို cookie / session နဲ့ မှတ်မိပါတယ်။ Bundled country / destination content ကိုလည်း ပြန်ဆိုထားပါတယ်။ Customer ရေးထားတဲ့ chat၊ review၊ hotel proper names နဲ့ admin က အသစ်ထည့်တဲ့ custom content တွေကို အလိုအလျောက် translate မလုပ်ပါ။ မြန်မာစာအတွက် device ရဲ့ Myanmar Text / Noto Sans Myanmar / Pyidaungsu font ကို သုံးပါတယ်။

## Demo data နဲ့ photos

Hotels၊ room prices၊ addresses၊ promotions တွေက fictional demonstration data ပါ။ တကယ့် hotel listing / စျေးနှုန်းမဟုတ်ပါ။ Review fake data မထည့်ထားပါ။ Photos က Unsplash က travel / stay stock images ဖြစ်ပြီး ZIP ထဲမှာ ပါလို့ page တက်ဖို့ external image requests မလိုပါ။ Destination photos ကို နိုင်ငံတစ်ခုအတွင်း demo listings တွေမှာ ပြန်သုံးထားတာဖြစ်လို့ တကယ့် hotel သို့မဟုတ် city တစ်ခုချင်းရဲ့ photo လို့ မသတ်မှတ်ပါနဲ့။ Photo source URLs က `ASSET_SOURCES.md` မှာပါပါတယ်။ Hakone ပုံသုံးပုံက AI ဖန်တီးထားသော နမူနာပုံများဖြစ်ပြီး တကယ်ကင်မရာရိုက်ထားသော ပုံများမဟုတ်ပါ။

## Real hosting ထည့်မယ်ဆိုရင်

Apache + PHP + MySQL/MariaDB hosting လိုပါတယ်။ `.htaccess` rules ကို AllowOverride နဲ့ enable လုပ်ထားပါ။ Nginx သုံးရင် config/includes/database/storage/vendor/tests၊ `.env`၊ SQL/log files ကို deny လုပ်တဲ့ rules ထပ်သတ်မှတ်ပါ။ Public uploads ကို PHP executable အဖြစ် မrunရပါ။ HTTPS သုံးပါ၊ dedicated DB user သတ်မှတ်ပါ၊ SMTP ကိုချိတ်ပါ၊ demo hotel/payment/contact information ကို အမှန်တကယ် data နဲ့ အစားထိုးပါ။

Remote first-admin setup မတိုင်ခင် `.env` မှာ random `SETUP_TOKEN` ကိုသတ်မှတ်ပြီး setup form မှာ အဲဒီ token ထည့်ရပါတယ်။ Token configured လုပ်ထားရင် localhost မှာလည်း လိုပါတယ်။ `storage/private` / `public/uploads` ကို PHP ရေးခွင့်ပေးထားပါ။

PHP built-in server သုံးရင် project folder ထဲမှာ `php -S localhost:8000 router.php` လို့ဖွင့်ပါ။ Provided router က private files ကို deny လုပ်ပါတယ်။ Built-in server ကို public production hosting အနေနဲ့ မသုံးပါနဲ့။

## Tests

`TEST_REPORT.md` မှာ စမ်းသပ်ထားတဲ့အချက်တွေကို ဖတ်နိုင်ပါတယ်။ HTML email / config ကို network မလိုဘဲ `php tests/email_template_test.php` နဲ့ စမ်းနိုင်ပါတယ်။ Save DOM simulation ကို `node tests/wishlist_dom_test.cjs`၊ availability / receipt / admin inbox simulation ကို `node tests/ui_interactions_test.cjs`၊ OTP / photo preview simulation ကို `node tests/account_ui_test.cjs`၊ resend / direct Edit simulation ကို `node tests/resend_editor_ui_test.cjs` နဲ့ စမ်းနိုင်ပါတယ်။ `tests/account_integration.php` က OTP purpose / replay / expiry / session binding / password version / confirmation ကို isolated test database မှာ စမ်းပါတယ်။ `tests/booking_integration.php` က availability၊ overbooking၊ date boundaries၊ promo pricing၊ cancellation၊ payment review နဲ့ expired holds ကို isolated test database မှာ စမ်းပါတယ်။ ကိုယ့် real database မှာ မrunပါနဲ့။ Test DB name က `_test` နဲ့ ဆုံးရပြီး `TRIPORA_TEST_ALLOW=1` ကို သတ်မှတ်ထားမှ run ပါမယ်။

## Folder structure

- `index.php` — home နဲ့ legacy bookmarks redirect
- `customer/` — customer pages၊ profile၊ trips၊ private receipt entry
- `auth/` — login၊ register၊ OTP၊ password reset
- `admin/` — dedicated login၊ dashboard၊ management pages
- `config/` — application၊ database၊ SMTP configuration၊ Myanmar language / catalogue dictionaries
- `includes/` — shared header/footer၊ helpers၊ actions၊ booking/mail/chat services၊ language helpers
- `api/` — Save / Unsave၊ availability၊ private chat၊ payment details JSON endpoints
- `public/` — CSS၊ JavaScript၊ photos၊ uploads
- `database/tripora.sql` — fresh install အတွက် tables 19 ခုနဲ့ demo catalogue
- `database/upgrade_v2.sql` — existing install အတွက် chat / Myanmar upgrade
- `database/upgrade_v3.sql` — existing install အတွက် profile photo / password OTP upgrade
- `database/upgrade_v4.sql` — legacy destination gallery / email delivery diagnostics upgrade
- `database/upgrade_v5.sql` — ပုံအရေအတွက် မကန့်သတ်သော gallery upgrade
- `storage/private/` — authenticated receipts
- `vendor/PHPMailer/` — SMTP library
- `tests/` — booking / account integration နဲ့ Save / availability / receipt / inbox / OTP / photo interaction tests

Booking amounts အားလုံး USD ပါ။ Transfer proof က real gateway verification မဟုတ်ပါ။ Administrator က ပို့ထားတဲ့ payment ကို ကိုယ်တိုင်စစ်ပြီးမှ confirm လုပ်ရပါတယ်။

## Destination gallery / Admin filters / OTP delivery (2026-10-11)

လက်ရှိ website update လုပ်ရန် `.env`၊ `public/uploads/` နှင့် `storage/private/` ကို backup / ထိန်းထားပြီး source files အသစ်ကို copy လုပ်ပါ။ Database ကိုမဖျက်ပါနှင့်။ လက်ရှိ Tripora database ကို phpMyAdmin မှာ ရွေးပြီး `database/upgrade_v5.sql` ကို Import လုပ်ပါ။ အရင် upgrade မလုပ်ရသေးရင် V2 → V3 → V4 → V5 အစဉ်လိုက် လုပ်ပါ။ Fresh install ဆို `tripora.sql` တစ်ခုတည်းတွင် အားလုံး ပါပြီးသားပါ။ Ctrl + F5 တစ်ကြိမ်နှိပ်ပါ။

**Destination gallery** — ရှိသမျှ destination အားလုံးမှာ main ပုံကြီးတစ်ပုံနဲ့ အောက်မှာ ပုံသေးသေးတစ်တန်းပါသည်။ Desktop thumbnail 54×42 px၊ mobile 48×38 px ဖြစ်ပြီး လက်ရှိ main မှာ ပြနေသောပုံ၏ thumbnail ကိုသာ မှုန်ဖျော့ထားပါသည်။ ပုံများလာလျှင် အောက်တန်းကို ဘေးတိုက် scroll လုပ်နိုင်ပါသည်။ Thumbnail / မြား / keyboard arrows / mobile swipe ဖြင့် refresh မဖြစ်ဘဲ ပုံပြောင်းနိုင်ပါသည်။ တစ်ပုံပဲရှိလျှင်လည်း thumbnail သေးသေးနဲ့ gallery တူညီစွာပြပါသည်။

Admin → Destinations မှာ နိုင်ငံရွေး → Edit ဖွင့်ပါ။ Image က primary photo ဖြစ်ပြီး Save record ဖြင့် ပြောင်းနိုင်ပါသည်။ **Gallery photos → Add photos** မှာ ပုံတစ်ပုံ သို့မဟုတ် အများအပြား ရွေးနိုင်ပါသည်။ ပုံတင်ခြင်းသည် တစ်ပုံချင်း background မှာ save လုပ်ပြီး gallery တစ်ခု၏ ပုံအရေအတွက်ကို application က မကန့်သတ်ထားပါ။ Gallery ပုံတစ်ပုံချင်း Replace / Remove လုပ်နိုင်ပါသည်။ Gallery ပြောင်းချိန် page refresh မဖြစ်ပါ။ Destination အသစ်ဆို အရင် Save record → Edit ဖွင့်ပြီး အပိုပုံထည့်ပါ။ Destination စာသားကို Save လုပ်ခြင်းက ယခင်အပိုပုံများကို မဖျက်ပါ။

JPG/PNG/WebP တစ်ပုံလျှင် 5 MB အများဆုံးပါ။ XAMPP `php.ini` မှာ `upload_max_filesize=5M`၊ `post_max_size=6M` သို့မဟုတ် ပိုကြီးသောတန်ဖိုးနှင့် `max_file_uploads` ကို သင့် PHP settings အတိုင်း ထိန်းထားပါ။ Gallery သည် request တစ်ခုလျှင် file တစ်ခုသာ ပို့သောကြောင့် gallery ထဲတွင် PHP ၏ တစ်ခါတင်နိုင်သည့် file အရေအတွက်ထက် ပိုများနိုင်ပါသည်။ PHP settings ပြောင်းလျှင် Apache restart လုပ်ပါ။ Batch အလယ်တွင် file တစ်ခုမအောင်မြင်ပါက save ပြီးသားပုံများကို ထိန်းထားပြီး ရပ်သွားသည်။ ပြထားသော count / error ကိုကြည့်ပြီး ကျန်ပုံများကို ထပ်ရွေးပါ။ Timeout ဖြစ်လျှင် duplicate မတင်မိစေရန် Edit ကို ပြန်ဖွင့်ပြီး gallery ကို အရင်စစ်ပါ။

Existing primary photo မပြောင်းပါ။ V5 က legacy Image 2 / Image 3 ကို gallery table ထဲသို့ တစ်ကြိမ်သာ ကူးပေးပါသည်။ ပြန် import လုပ်လည်း ဖယ်ထားသောပုံကို ပြန်မထည့်ပါ။ Hakone ၏ နမူနာ AI ပုံသုံးပုံ ပါဝင်ပြီး နေရာအားလုံးအတွက် အပိုဓာတ်ပုံများ အသစ်ထည့်ထားခြင်း မဟုတ်ပါ။ တခြား destinations တွင် Admin မှ ကိုက်ညီသောပုံများကို ထည့်နိုင်ပါသည်။

**Admin filters / Search** — Destinations နှင့် Hotels နှစ်ခုလုံးတွင် နိုင်ငံမရွေးဘဲ Search ဖြင့် name / location သို့မဟုတ် name / address ကို နိုင်ငံအားလုံးအတွင်း ရှာနိုင်ပါသည်။ Country တွင် All countries ရွေးထားလျှင် ရှာဖွေမှုကို နိုင်ငံမကန့်သတ်ပါ။ နိုင်ငံရွေးထားလျှင် ထိုနိုင်ငံအတွင်းသာ ရှာပါသည်။ Hotels တွင် နိုင်ငံရွေးပြီး Destination ဖြင့် ထပ်ခွဲနိုင်ပါသည်။ နိုင်ငံမရွေး၊ Search မရိုက်ထားလျှင် စာရင်းအရှည် မပြဘဲ နိုင်ငံရွေးရန် သို့မဟုတ် ရှာရန် prompt ပြပါသည်။ Search label ကို Search ဟုသာ ပြထားပြီး စာရိုက်ချိန် page refresh မဖြစ်ဘဲ results ပြောင်းပါသည်။ Inactive records များကိုလည်း Admin က ရှာ၍ ပြင်နိုင်ပါသည်။

Filter ပြောင်း / စာရိုက်ချိန် results ကို background မှာ update လုပ်ပြီး အရင် response က အသစ်ရွေးထားသော filter ကို မလွှမ်းမိုးပါ။ တစ်မျက်နှာ 20 records ဖြင့် Previous / Next ပါသည်။ ရှာမတွေ့လျှင် empty state ပြပြီး table အဟောင်းကို မထားပါ။ Result တစ်ခု၏ Edit ကို နှိပ်လျှင် record မှန်ကို တိုက်ရိုက်ဖွင့်သည်။ Add destination လုပ်လျှင် လက်ရှိနိုင်ငံကို အလိုအလျောက် ရွေးပေးပါသည်။ Save record လုပ်သည့် ပုံမှန် form submission သည် page navigation ရှိဆဲဖြစ်ပြီး သက်ဆိုင်ရာ country / destination filter သို့ ပြန်ရောက်ပါသည်။ Browser JavaScript ပိတ်ထားလျှင် filter ရွေးပြီး Search ကို နှိပ်၍ ပထမစာမျက်နှာကို ကြည့်နိုင်ပါသည်။ Gallery management နှင့် live search အတွက် JavaScript လိုပါသည်။

**OTP မရောက်လျှင်** — Admin → Settings → Email delivery မှာ customer က Tripora တွင် register လုပ်ထားသော email ကိုထည့်ပြီး Check email နှိပ်ပါ။ Account မရှိ / inactive ဖြစ်လျှင် forgot-password က code မပို့ပါ။ Public page တွင် account ရှိမရှိကို မဖော်ပြဘဲ conditional message ပေးထားပါသည်။ Admin မှာသာ account နှင့် နောက်ဆုံးပို့ထားမှုငါးခုကို တွေ့ပါမည်။ `Not sent` ဆို matching active account မရှိပါ။ `Failed` ဆို safe SMTP error explanation ကို ကြည့်ပါ။ `SMTP accepted` ဆို mail server က လက်ခံပြီးဖြစ်သော်လည်း Inbox ထိရောက်ပြီဟု မဆိုလိုပါ။ Inbox / Spam ကို စစ်ပါ။

Send test to my admin email ခလုတ်က သင်ဝင်ထားသော Admin email ကိုသာ စမ်းပို့ပါသည်။ Customer OTP / password ကို မပြောင်းပါ။ SMTP_USER က ပို့ပေးမည့် Gmail account ဖြစ်ပြီး customer OTP recipient က customer ၏ account email ဖြစ်ပါသည်။ `.env` မှာ smtp.gmail.com၊ port 587 / tls (သို့) 465 / ssl၊ sender email အပြည့်အစုံနှင့် Gmail App Password ကို ဖြည့်ထားရပါမည်။ Google account မှာ 2-Step Verification ဖွင့်မှ App Password သုံးနိုင်ပါသည်။ ပို့သူ၏ Google password ပြောင်းထားလျှင် App Password အသစ်ဖန်တီးရနိုင်ပါသည်။ Settings values တွေကို public page / error messages တွင် မပြပါ။

Official Google references: [App passwords](https://support.google.com/accounts/answer/185833?hl=en), [SMTP settings](https://support.google.com/mail/answer/7104828?hl=en-en).

Email delivery history သည် account email၊ purpose၊ status၊ safe explanation နှင့် UTC timestamp ကိုသာ database တွင် သိမ်းပြီး 30 ရက်ကျော်သော entries ကို delivery အသစ်များမှ တဖြည်းဖြည်းဖျက်သည်။ OTP code / SMTP password / raw SMTP replies ကို မသိမ်းပါ။ V4 မသွင်းရသေးလျှင် ယခင် OTP sending flow အလုပ်လုပ်ဆဲဖြစ်ပြီး diagnostics သုံးရန် migration လိုပါမည်။

စမ်းသပ်မှုများတွင် PHP/MariaDB နှင့် authenticated TLS SMTP fixture ကို အသုံးပြုထားပါသည်။ သင့် real Gmail settings၊ Inbox delivery၊ သင့် XAMPP/Apache နှင့် mobile browser ကို အမှန်တကယ် remote စမ်းထားခြင်းမရှိပါ။ Gallery controls simulation ကို `node tests/destination_gallery_test.cjs`၊ Admin ပုံစီမံမှုကို `node tests/admin_gallery_test.cjs`၊ live filter/search ကို `node tests/admin_catalogue_test.cjs` ဖြင့် run နိုင်ပါသည်။ Browser visual test ကို ဤ environment တွင် မလုပ်နိုင်သေးပါ။


## Search / thumbnail correction (2026-10-11)

ယခင် V5 update လုပ်ပြီးသားဆို ဤပြင်ဆင်မှုအတွက် SQL အသစ် import မလိုပါ။ `.env`၊ `public/uploads/` နှင့် `storage/private/` ကို ထိန်းထားပြီး source files ကို update လုပ်ပါ။ Assets version 8 ဖြစ်ပြီး Ctrl + F5 တစ်ကြိမ်နှိပ်ပါ။ Gallery HTML tag ပြင်ထားသဖြင့် ပထမပုံအပါအဝင် thumbnail အားလုံးကို နှိပ်၍ ပြောင်းနိုင်ပြီး လက်ရှိပြနေသောပုံ၏ thumbnail ကိုသာ မှုန်ထားပါသည်။
