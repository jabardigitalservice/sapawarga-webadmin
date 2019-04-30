SELECT id, name,
       latitude, longitude, distance
  FROM (
 SELECT pb.id,
        pb.name,
        pb.latitude, pb.longitude,
        c.radius,
        c.distance_unit
                 * DEGREES(ACOS(COS(RADIANS(c.latpoint))
                 * COS(RADIANS(pb.latitude))
                 * COS(RADIANS(c.longpoint - pb.longitude))
                 + SIN(RADIANS(c.latpoint))
                 * SIN(RADIANS(pb.latitude)))) AS distance
  FROM phonebooks AS pb
  JOIN (   /* these are the query parameters */
        SELECT  :latitude AS latpoint, :longitude AS longpoint,
                :radius AS radius, 111.045 AS distance_unit
    ) AS c ON 1=1
  WHERE pb.latitude
     BETWEEN c.latpoint  - (c.radius / c.distance_unit)
         AND c.latpoint  + (c.radius / c.distance_unit)
    AND pb.longitude
     BETWEEN c.longpoint - (c.radius / (c.distance_unit * COS(RADIANS(c.latpoint))))
         AND c.longpoint + (c.radius / (c.distance_unit * COS(RADIANS(c.latpoint))))
    AND pb.status <> -1
 ) AS d
 WHERE distance <= radius
 ORDER BY distance
