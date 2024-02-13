<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frame Car | استجابة للطلب</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            width: 100%;
            background-color: #1B1A17;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .header h1 p {
            color: #F58020;
        }

        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .button {
            padding: 10px 28px 11px 28px;
            margin-right: 10px 0 0 0;
            border-radius: 50px;
            color: #1B1A17;
            font-size: 16px;
            letter-spacing: 1px;
            display: inline-block;
            border: 2px solid #F58020;
            font-weight: 600;
            text-decoration: none;
        }

        .button:hover {
            color: #fff;
            background: linear-gradient(90deg, rgba(245,128,32,1) 40%, rgba(245,178,32,1) 100%);
        }

        .footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            /* Mobile-specific styles */
            .header h1 {
                text-align: right;
            }
            .button {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
<div class="container" dir="rtl">
    <div class="header">
        <h1>
            قرار حسم حول الحضور والغياب
        </h1>
    </div>
    <div class="content">
        <p>مرحباً،</p>
        <p>يؤسفنا إعلامكم بقرار الحسم الخاص بالحضور أو الغياب.</p>
        <p>التفاصيل كالتالي:</p>
        <ul>
            <li>الوصف: {{ $data['description'] }}</li>
        </ul>
        <p>أطيب التحيات،<br>فريق المتابعة</p>
    </div>
    <div class="footer">
        جميع الحقوق محفوظة &copy; {{ date('Y') }} الحضور والغياب
    </div>
</div>
</body>
</html>
