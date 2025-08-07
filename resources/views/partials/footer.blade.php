<footer class="footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-info">
                <span class="footer-text">&copy; {{ date('Y') }} Catsbook. Все права защищены.</span>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        background: #f8f9fa;
        /* Светло-серый фон */
        border-top: 1px solid #e0e0e0;
        /* Тонкая граница сверху */
        padding: 1rem 0;
        /* Вертикальный отступ */
        margin-top: auto;
        /* Прижимает футер к низу, если используется flexbox для body/html */
        color: #6c757d;
        /* Цвет текста серо-голубой, как в хедере */
        font-size: 0.9rem;
        /* Немного меньший размер шрифта */
    }

    .footer-container {
        max-width: 1200px;
        text-align: center;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .footer-info {
        flex: absolute;
        min-width: 200px;
        /* Минимальная ширина для текста копирайта */
    }

    .footer-text {
        /* Цвет наследуется от .footer */
    }

    /* Адаптивность для мобильных устройств */
    @media (max-width: 768px) {
        .footer-container {
            padding: 0 1rem;
        }

        .footer-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
    }
</style>