#include <iostream>
#include <random>
#include <chrono>
#include <unordered_map>
#include <iostream>
#include <fstream>


using namespace std;
struct parkingGarage
{
    int ownerId;
    int Id;
    int Latitude;
    int Longitude;
    int cost_per_hour;
    int Total_parking_spaces;
    int Total_available_parking_spaces;
    int Total_occupied_parking_spaces;
    int Floor_total_available_parking_spaces;
    int numFloors;
    vector<struct Floor> floors;
    

};

struct Floor
{
    int Total_available_parking_spaces;
};

// Provides(Parking Facility Owner Id, Parking Garage Id, Cost per hour, Day start time, Day end time)
struct providesTuple
{
    int ParkingFacilityOwnerId;
    int ParkingGarageId;
    int Costperhour;
    int Daystarttime;
    int Dayendtime;
};

struct parksAtTuple
{
    int garageId;
    int floorId;
    int driverId;
    int applied_cost_per_hour;
    int applied_discount;
    int total_hours;
    int total_cost;
    int start_time_int;
    int end_time_int;
};

int main()
{   
    int seed = chrono::system_clock::now().time_since_epoch().count();
    std::mt19937 random_generator(seed);
    std::uniform_int_distribution<int> dist_lat_long(-500,500);
    std::uniform_int_distribution<int> dist_floor_spaces_multiplier(5,20);
    std::uniform_int_distribution<int> dist_num_floors(1,5);
    std::uniform_int_distribution<int> dist_num_garages(1,5);
    std::uniform_int_distribution<int> dist_cost_per_hour_multiplier(1,5);

    int numParkingGarageOwners = 30;
    int maxNumProvidedGarages = 5;
    int maxNumFloors = 5;

    int runningTotalGarages = 0;
    vector<parkingGarage> garages;
    for(int i=1; i <= numParkingGarageOwners; i++)
    {   
        int num_garages = dist_num_garages(random_generator);
        for(int j=1; j <= num_garages; j++)
        {   

            parkingGarage garage;
            garage.ownerId = i;
            garage.Id = runningTotalGarages;
            garage.Latitude = dist_lat_long(random_generator);
            garage.Longitude = dist_lat_long(random_generator);
            garage.Floor_total_available_parking_spaces = 10 * dist_floor_spaces_multiplier(random_generator);
            garage.numFloors = dist_num_floors(random_generator);
            garage.Total_parking_spaces = garage.numFloors * garage.Floor_total_available_parking_spaces;
            garage.Total_available_parking_spaces = garage.Total_parking_spaces;
            garage.Total_occupied_parking_spaces = 0;
            garage.cost_per_hour = 3 * dist_cost_per_hour_multiplier(random_generator);

            vector<Floor> floors;
            for(int k = 0; k < garage.numFloors; k++)
            {
                Floor floor;
                floor.Total_available_parking_spaces = garage.Floor_total_available_parking_spaces;
                floors.push_back(floor);
            }
            garage.floors = floors;

            garages.push_back(garage);
            runningTotalGarages += 1;
        } 
    }

    int TotalGarages = runningTotalGarages;
    std::uniform_int_distribution<int> dist_num_driver_parks_at(1,3);
    std::uniform_int_distribution<int> dist_garage_idx(0,TotalGarages-1);
    std::uniform_int_distribution<int> dist_interval_length(1,3);

    //It is assumed that all garage times are 7AM - 6PM
    //This can be modified, but the assumption is easier
    std::uniform_int_distribution<int> dist_start_time(0, 10);

    vector<parksAtTuple> parksAt;    
    int numDrivers = 1000;
    for(int i = 1; i <= numDrivers; i++)
    {   
        int num_driver_parks_at = dist_num_driver_parks_at(random_generator);
        
        //vector of (garage_idx, floor_idx)
        vector<pair<int,int>> garage_idx_floor_idx_pairs;
        for(int j = 0; j < num_driver_parks_at; j++)
        {
            int garage_idx;
            int floor_idx;

            bool foundGarage = false;
            while(!foundGarage)
            {
                garage_idx = dist_garage_idx(random_generator);
                parkingGarage garage = garages[garage_idx];
                if(garage.Total_available_parking_spaces > 0)
                {
                    foundGarage = true;
                    bool foundFloor = false;
                    
                    std::uniform_int_distribution<int> dist_floor_idx(0,garage.numFloors);
                    while(!foundFloor)
                    {
                        floor_idx = dist_floor_idx(random_generator);
                        Floor floor = garage.floors[floor_idx];
                        if(floor.Total_available_parking_spaces > 0)
                        {   
                            foundFloor = true;
                            floor.Total_available_parking_spaces -= 1;
                            garage.Total_available_parking_spaces -= 1;

                            //Reassign updated floor
                            garage.floors[floor_idx] = floor;

                            //Reassign updated parking garage
                            garages[garage_idx] = garage;
                        }
                    }
                }
            }
            
            pair<int,int> garage_idx_floor_idx_pair{garage_idx, floor_idx};
            garage_idx_floor_idx_pairs.push_back(garage_idx_floor_idx_pair);
        }
    
        //vector of (start time, end time)
        vector<pair<int,int>> start_time_end_time_pairs;
        for(int j=0; j < num_driver_parks_at; j++)
        {   
            int intervalLength = dist_interval_length(random_generator);

            bool foundInterval = false;
            while(!foundInterval)
            {   
                
                int start_time = dist_start_time(random_generator);
                int end_time = start_time + intervalLength;

                bool validInterval = true;
                for(int k = 0; k < j; k ++)
                {
                    pair<int,int> start_time_end_time_pair = start_time_end_time_pairs[k];
                    if(!(start_time >= start_time_end_time_pair.second || end_time <= start_time_end_time_pair.first))
                    {
                        validInterval = false;
                    }
                }

                if(validInterval)
                {
                    foundInterval = true;

                    pair<int,int> start_time_end_time_pair{start_time, end_time};
                    start_time_end_time_pairs.push_back(start_time_end_time_pair);
                }
                
            }
        }
        
        // struct parksAtTuple
        // {
        //     int garageId;
        //     int floorId;
        //     int driverId;
        //     int applied_cost_per_hour;
        //     int applied_discount;
        //     int total_hours;
        //     int start_time_int;
        //     int end_time_int;
        // };
        
        for(int j=0; j < num_driver_parks_at; j++)
        {   
            pair<int,int> garage_idx_floor_idx_pair = garage_idx_floor_idx_pairs[j];
            pair<int,int> start_time_end_time_pair = start_time_end_time_pairs[j];

            int garage_idx = garage_idx_floor_idx_pair.first;
            int floor_idx = garage_idx_floor_idx_pair.second;

            int start_time = start_time_end_time_pair.first;
            int end_time = start_time_end_time_pair.second;
            int duration = end_time - start_time;

            parkingGarage garage = garages[garage_idx];


            parksAtTuple ParksAtTuple;
            ParksAtTuple.garageId = (garage_idx+1);
            ParksAtTuple.floorId = (floor_idx+1);
            ParksAtTuple.driverId = (i+1);
            ParksAtTuple.applied_cost_per_hour = garage.cost_per_hour;
            ParksAtTuple.applied_discount = 0;
            ParksAtTuple.total_hours = duration;
            ParksAtTuple.total_cost = duration * ParksAtTuple.applied_cost_per_hour;
            ParksAtTuple.start_time_int = start_time;
            ParksAtTuple.end_time_int = end_time;

            parksAt.push_back(ParksAtTuple);
        }
        


        //Next, for each (garage_idx, floor_idx, start time, end time)
        //Compute number of times driver has parked in parking garages owned by the owner of the parking garage
        //Compute the discount as min(20%, 3% off for every past visit)
        //Assign Parks at (garage_idx, floor_idx, start time, end time)
        //Obtain floor, subtract 1 from floor's available spaces
        //Obtain garage, subtract 1 from garage's total avaliable spaces

        //The steps then obtain ParksAt
    }

    //The steps obtained all tables
    //Next, format the tables and write each to a .tbl file

    // Parking Facility Owner(Parking Facility Owner Id, Name, Identification Number)
    ofstream os("../ParkingTables/ParkingFacilityOwner");
    for(int i=0; i < numParkingGarageOwners; i++)
    {
        int ParkingFacilityOwnerId = (i+1);
        os << ParkingFacilityOwnerId << "|" 
        << "Parking Facility Owner " + to_string(ParkingFacilityOwnerId) << endl;

        //Required: Identification Number
    }
    os.close();
    
    // Parking Garage(Parking Garage Id, Latitude, Longitude, Total parking spaces, Total available parking spaces)
    os.open("../ParkingTables/ParkingGarage");
    for(int i = 0; i < TotalGarages; i++)
    {   
        parkingGarage garage = garages[i];
        int ParkingGarageId = (i+1);
        os << ParkingGarageId << "|"
        << to_string(garage.Latitude) << "|" 
        << to_string(garage.Longitude) << "|" 
        << to_string(garage.Total_parking_spaces) << "|"
        << to_string(garage.Total_available_parking_spaces) << endl;
    }
    os.close();



    // Floor(Parking Garage Id, Floor Id, Floor Level, Floor total parking spaces, Floor available parking spaces)
    os.open("../ParkingTables/Floor");
    int floor_idx = 0;
    int garage_idx;
    for(int i=0; i < numParkingGarageOwners; i++)
    {   
        int ParkingGarageId = (garage_idx+1);

        parkingGarage garage = garages[i];
        for(int j=0; j < garage.numFloors; j++)
        {   
            Floor floor = garages[i].floors[j];
            
            int ParkingGarageId = (i+1);
            int FloorId = (j+1);
            int FloorLevel = (j+1);
            int FloorTotalParkingSpaces = garage.Floor_total_available_parking_spaces;
            int FloorAvailableParkingSpaces = floor.Total_available_parking_spaces;



            os << to_string(ParkingGarageId) << "|" 
            << to_string(FloorId) << "|"
            << to_string(FloorLevel) << "|"
            << to_string(FloorTotalParkingSpaces) << "|"
            << to_string(FloorAvailableParkingSpaces) << endl;
        }
    }
    os.close();

    // Driver(Driver Id, Name)
    os.open("../ParkingTables/Driver");
    for(int i=0; i < numDrivers; i ++)
    {
        int DriverId = (i+1);
        string name = "Driver " + to_string(i);

        os << to_string(i) << "|"
        << name << endl;
    }
    os.close();

    // Provides(Parking Facility Owner Id, Parking Garage Id, Cost per hour, Day start time, Day end time)
    os.open("../ParkingTables/Provides");
    int GaragesSize = garages.size();
    for(int i=0; i < GaragesSize; i++)
    {   
        parkingGarage garage = garages[i];

        providesTuple providestuple;
        providestuple.ParkingFacilityOwnerId = garage.ownerId;
        providestuple.ParkingGarageId = garage.Id;
        providestuple.Costperhour = garage.cost_per_hour;
        providestuple.Daystarttime = 7;
        providestuple.Dayendtime = 18;

        os << to_string(providestuple.ParkingFacilityOwnerId) << "|" 
        << to_string(providestuple.ParkingGarageId) << "|" 
        << to_string(providestuple.Costperhour) << "|" 
        << to_string(providestuple.Daystarttime) << "|" 
        << to_string(providestuple.Dayendtime) << endl;
    }
    os.close();

    // Parks at(Driver Id, Parking Garage Id, Floor Id, Total hours, Total cost, Applied cost per hour, Applied discount amount, Vehicle License Number)
    os.open("../ParkingTables/ParksAt");
    int ParksAtSize = parksAt.size();
    for(int i=0; i < ParksAtSize; i++)
    {   
        parksAtTuple parksat = parksAt[i];

        int DriverId;
        int ParkingGarageId;
        int FloorId;
        int Totalhours;
        int Totalcost;
        int Appliedcostperhour;
        int Applieddiscountamount;
        int VehicleLicenseNumber;
        int startTime;
        int endTime;


        os << to_string(parksat.driverId) << "|" 
        << to_string(parksat.garageId) << "|" 
        << to_string(parksat.floorId) << "|" 
        << to_string(parksat.total_hours) << "|" 
        << to_string(parksat.total_cost) << "|" 
        << to_string(parksat.applied_cost_per_hour) << "|" 
        << to_string(parksat.applied_discount) << "|" 
        << "Vehicle License Number Placeholder" << endl;    
    }
    os.close();

}