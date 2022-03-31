import org.apache.spark.sql.SparkSession
import org.apache.spark.sql.DataFrame
import com.mongodb.spark._
import org.apache.spark.sql.{ SaveMode }
import org.apache.spark._

val spark = SparkSession.builder().appName("MongoSparkDataFrame").master("local").getOrCreate()

// Step 1 create the Dataframe source
//Modifier les chemins pour récupérer les datasets
val yelpBusiness = spark.read.json("../../dataset/yelp_academic_dataset_business.json")
val yelpUsers = spark.read.json("../../dataset/yelp_academic_dataset_user.json")
val yelpReview = spark.read.json("../../dataset/yelp_academic_dataset_review.json")

yelpBusiness.printSchema()
yelpUsers.printSchema()
yelpReview.printSchema()

yelpBusiness.createOrReplaceTempView("yelpBusiness")
yelpUsers.createOrReplaceTempView("yelpUsers")
yelpReview.createOrReplaceTempView("yelpReview")

val business = spark.sql("SELECT yelpBusiness.business_id, first(yelpBusiness.name) as name, first(yelpBusiness.address) as address, first(yelpBusiness.city) as city, first(yelpBusiness.latitude) as latitude, first(yelpBusiness.longitude) as longitude, first(yelpBusiness.stars) as rating, first(categories) as categories, first(hours) as hours, first(attributes).BusinessAcceptsCreditCards as BusinessAcceptsCreditCards, first(attributes).RestaurantsReservations as RestaurantsReservations, first(attributes).WheelchairAccessible as WheelchairAccessible, first(attributes).OutdoorSeating as OutdoorSeating, first(attributes).HappyHour as HappyHour, first(attributes).DogsAllowed as DogsAllowed, COUNT(yelpReview.review_id) AS review_count FROM yelpBusiness LEFT JOIN yelpReview ON yelpReview.business_id = yelpBusiness.business_id WHERE yelpBusiness.is_open = 1 GROUP BY yelpBusiness.business_id")
val user = spark.sql("SELECT user_id, name, yelping_since FROM yelpUsers")
val review  = spark.sql("SELECT review_id, user_id, business_id, stars, text, date FROM yelpReview")

// // Step 2, insert Dataframe into MongoDB  

MongoSpark.save(business.write.option("collection", "business").mode(SaveMode.Append))
MongoSpark.save(user.write.option("collection", "user").mode(SaveMode.Append))
MongoSpark.save(review.write.option("collection", "review").mode(SaveMode.Append))