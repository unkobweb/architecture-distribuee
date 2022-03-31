import org.apache.spark.sql.SparkSession
import org.apache.spark.sql.DataFrame
import com.mongodb.spark._
import org.apache.spark.sql.{ SaveMode }
import org.apache.spark._

val spark = SparkSession.builder().appName("MongoSparkDataFrame").master("local").getOrCreate()

// Step 1 create the Dataframe source
//Modifier les chemins pour récupérer les datasets
val yelpBusiness = spark.read.json("dataset/yelp_academic_dataset_business.json")
val yelpUsers = spark.read.json("dataset/yelp_academic_dataset_user.json")
val yelpReview = spark.read.json("dataset/yelp_academic_dataset_review.json")

yelpBusiness.printSchema()
yelpUsers.printSchema()
yelpReview.printSchema()

yelpBusiness.createOrReplaceTempView("yelpBusiness")
yelpUsers.createOrReplaceTempView("yelpUsers")
yelpReview.createOrReplaceTempView("yelpReview")

val business = spark.sql("SELECT business_id, name, address, city, latitude, longitude, stars as rating, review_count categories, hours, attributes.BusinessAcceptsCreditCards, attributes.RestaurantsReservations, attributes.WheelchairAccessible, attributes.OutdoorSeating, attributes.HappyHour, attributes.DogsAllowed FROM yelpBusiness WHERE is_open = 1")
val user = spark.sql("SELECT user_id, name, yelping_since FROM yelpUsers")
val review  = spark.sql("SELECT review_id, user_id, business_id, stars, text, date FROM yelpReview")

// // Step 2, insert Dataframe into MongoDB  

MongoSpark.save(business.write.option("collection", "business").mode(SaveMode.Append))
MongoSpark.save(user.write.option("collection", "user").mode(SaveMode.Append))
MongoSpark.save(review.write.option("collection", "review").mode(SaveMode.Append))