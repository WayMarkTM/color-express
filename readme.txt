1. Устанавливаем OpenServer - достаточно облегченной версии
2. Создаем папку в domains (в моем случае yii-colorexp)
3. Запускаем openserver и выбираем консоль
4. Зайти в папку domains через консоль open server и прописать
	composer global require "fxp/composer-asset-plugin:^1.2.0"
	composer create-project --prefer-dist yiisoft/yii2-app-basic (имя созданной папки в которую будем устанавливтаь yii)
5. Заходим по адресу http://{имя папки}/web и проверяем работоспособность