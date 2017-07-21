# Optimus
This is the project which I create for **AbinBev Hackathon Feb-2017**. It is a web app which is home to a powerful Artificial Intelligence(AI), named as Optimus. which help business visualise their data sets and get better insights into the factors which are driving sales.

This app allows all the retailer's or shop owners to upload their monthly or weekly sales data (as a CSV or Excel file) and then by machine learning it create a database automatically. Once the database is ready, it visualises all the data sets in the form charts and graphs, also it analyses all the data sets to tell you about important insights below every visualisation. Those important insights include `When to advertise for more sales`, `When to give offers to customers`, `Which product to produce more`,  `which product needs attention` etc. This app also provides you with random facts about your industry.

# Other Features

 ### 1) OCR for SKU images.
This app allows you to upload SKU (stock keeping unit) images and then Optimus do image processing to read those images and try to find out if bottles are placed in their right spot or if prices are right on those bottles. Optimus use [tesseract](https://github.com/thiagoalessio/tesseract-ocr-for-php) library for image processing

`This feature a bit incomplete`

### 2) Investment simulator
This is one of the best features of Optimus, it allows Optimus to use current data sets to predict about the **return on investment (ROI)**. This feature takes two inputs, first is amount/money we want to invest and second is the brand in which we want to invest, once you run the simulation, Optimus analyse various data sets and rate this investment out of 100. This rating helps you to get the confidence about your investment. if the rating is 80 or something, then it's good. if the rating is 50 or something then there are 50/50 chances of it being good and if the rating is below 30 or 40 then it is very risky and its chances of being profitable are very low.

`This feature is a bit incomplete`
