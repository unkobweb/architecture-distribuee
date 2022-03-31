import org.apache.spark._
import org.apache.spark.streaming._
import org.apache.spark.streaming.StreamingContext._ // not necessary since Spark 1.3
import org.apache.spark.sql.SparkSession
import org.apache.spark.sql.DataFrame
import com.mongodb.spark._
import org.apache.spark.sql.{ SaveMode }

// Create a local StreamingContext with two working thread and batch interval of 1 second.
// The master requires 2 cores to prevent a starvation scenario.
val ssc = new StreamingContext(sc, Seconds(1))

// Create a DStream that will connect to hostname:port, like localhost:9999

val lines = ssc.socketTextStream(if (System.getenv("SCALA_ENV") == "production") "server" else "server", 9999)
println(System.getenv("SCALA_ENV"))
lines.foreachRDD({ rdd =>
    import spark.implicits._
    val yelpBusiness = spark.read.json(rdd)
    yelpBusiness.createOrReplaceTempView("yelpBusiness")
    yelpBusiness.printSchema
    val business = spark.sql("SELECT id AS business_id, name, location.address1 AS address, location.city,  coordinates.latitude, coordinates.longitude, rating, concat_ws(',', categories.title) AS categories, image_url FROM yelpBusiness WHERE is_closed = false")
    MongoSpark.save(business.write.option("collection", "spark").mode(SaveMode.Append))
    })

ssc.start()             // Start the computation