import org.apache.spark._
import org.apache.spark.streaming._
import org.apache.spark.streaming.StreamingContext._ // not necessary since Spark 1.3

// Create a local StreamingContext with two working thread and batch interval of 1 second.
// The master requires 2 cores to prevent a starvation scenario.

val ssc = new StreamingContext(sc, Seconds(1))

// Create a DStream that will connect to hostname:port, like localhost:9999
val lines = ssc.socketTextStream(if (System.getenv("SCALA_ENV") == "production") "server" else "localhost", 9999)

// Print the first ten elements of each RDD generated in this DStream to the console
lines.print()

ssc.start()             // Start the computation
ssc.awaitTermination()  // Wait for the computation to terminate