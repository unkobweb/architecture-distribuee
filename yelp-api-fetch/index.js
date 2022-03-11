import dotenv from 'dotenv';
import axios from 'axios';
import inquirer from 'inquirer';
dotenv.config();

if (!process.env.YELP_API_KEY) {
  console.log('YELP_API_KEY is undefined');
  process.exit(1);
}

(async () => {
    const {location} = await inquirer.prompt([
        {
            type: 'input',
            name: 'location',
            message: 'What is the location you want to research?',
            validate: function(value) {
                if (value.length) {
                    return true;
                } else {
                    return 'Please enter a location';
                }
            }
        },
    ]);

    const yelp = axios.create({
        baseURL: 'https://api.yelp.com/v3/businesses',
        headers: {
            Authorization: `Bearer ${process.env.YELP_API_KEY}`,
        },
    });
    
    const res = await yelp.get('/search', {
        params: {
            location: location,
            limit: 50,
        },
    });
    
    console.log(res.data.businesses);
})();