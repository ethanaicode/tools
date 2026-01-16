# 收款码设置说明

## 如何添加收款码

将您的收款码图片放在项目根目录下，文件名分别为：

- 支付宝收款码：`qrcode-alipay.png`
- 微信收款码：`qrcode-wechat.png`

## 如何获取收款码

### 支付宝收款码
1. 打开支付宝APP
2. 点击首页的"收钱"
3. 点击"保存图片"
4. 将图片重命名为 `qrcode-alipay.png` 并放到项目根目录

### 微信收款码
1. 打开微信APP
2. 点击右上角"+"号
3. 选择"收付款" -> "我要收款"
4. 点击"保存收款码"
5. 将图片重命名为 `qrcode-wechat.png` 并放到项目根目录

## 修改代码显示收款码

在 `index.html` 的第 354 行和第 359 行，取消注释以下代码：

```javascript
// 支付宝收款码
qrcodeImage.innerHTML = `<img src="qrcode-alipay.png" style="width: 100%; height: 100%; object-fit: contain;" alt="支付宝收款码">`;

// 微信收款码
qrcodeImage.innerHTML = `<img src="qrcode-wechat.png" style="width: 100%; height: 100%; object-fit: contain;" alt="微信收款码">`;
```

并注释掉占位文本的代码。
