<?php 

include 'config.php';

$sql = "
INSERT INTO `product` (`prod_id`, `prod_img_name`, `prod_name`, `prod_desc`, `prod_price`, `prod_region`, `prod_numAvailable`, `prod_numSold`) VALUES 
('1', 'Item_Pile_Em_Up.webp', 'Pile ''Em Up', 'A rich, meaty dish. Originally a Mondstadt dish made of steaks, potatoes, and cheese, it has since become synonymous with Ludi Harpastum.', '13.7', 'Mondstadt', '99', '300'),
('2', 'Item_Apple_Cider.webp', 'Apple Cider', 'A freshly squeezed, fashionable, and fruity non-alcoholic beverage. Said to have a strong sobering effect, tavern patrons often order this as the last drink of the night.', '15.3', 'Mondstadt', '99', '300'),
('3', 'Item_Barbatos_Ratatouille.webp', 'Barbatos Ratatouille', 'A simple chowder with a long history. After much careful stewing, the flavors of three different vegetables have been blended to perfection. Like this, it is not hard to imagine why someone once called it \"the best chowder I\'ve ever tasted.\"', '11.2', 'Mondstadt', '99', '300'),
('4', 'Item_Berry_Mint_Burst.webp', 'Berry & Mint Burst', 'A freshly squeezed, fashionable, and fruity non-alcoholic beverage. A refreshing burst of Mint with Berries to sweeten the deal, it has an exquisite aroma.', '19.5', 'Mondstadt', '99', '300'),
('5', 'Item_Calla_Lily_Seafood_Soup.webp', 'Calla Lily Seafood Soup', 'A balanced combination of seafood. The crab, mint and calla lily come together perfectly to dance on your tongue. It reminds you of playing barefoot by the lake in summer.', '17.8', 'Mondstadt', '99', '300'),
('6', 'Item_Chicken-Mushroom_Skewer.webp', 'Chicken-Mushroom Skewer', 'A skewer of mushrooms and poultry. Fresh poultry is complimented by fragrant mushrooms. Don\'t be picky, chow down!', '10.4', 'Mondstadt', '99', '300'),
('7', 'Item_Cold_Cut_Platter.webp', 'Cold Cut Platter', 'A plate of cold cut meat. The seasoning is just delightful enough to bring out the flavors perfectly. With a mouth full of meaty ecstasy, one worries about nothing.', '16.1', 'Mondstadt', '99', '300'),
('8', 'Item_Crab_Veggie_Bake.webp', 'Crab, Ham & Veggie Bake', 'A luxurious bake. Cracks through the golden outer skin reveal a medley of rosy ham and bright vegetables. How tantalizing!', '18.9', 'Mondstadt', '99', '300'),
('9', 'Item_Cream_Stew.webp', 'Cream Stew', 'A meat and vegetable stew. The thick juices taste great with the tender meat and vegetables.', '12.3', 'Mondstadt', '99', '300'),
('10', 'Item_Flaming_Red_Bolognese.webp', 'Flaming Red Bolognese', 'Bolognese covered with a meat sauce. The beautiful, authentic flavors take you on a culinary adventure from the first bite to the last.', '14.6', 'Mondstadt', '99', '300'),
('11', 'Item_Goulash.webp', 'Goulash', 'A steaming-hot stew. Just one spoonful sends a down-to-earth sense of satisfaction welling up from the depths of your heart. The meat\'s flavor grows with every chew, bringing limitless strength to the eater even in the coldest wintry wastes.', '11.8', 'Mondstadt', '99', '300'),
('12', 'Item_Mondstadt_Hash_Brown.webp', 'Mondstadt Hash Brown', 'A fried cake of mashed potatoes. A little bit of pinecone helps give it a nice crunch, and great with a bit of jam. Loved by people of all ages.', '19.2', 'Mondstadt', '99', '300'),
('13', 'Item_Northern_Apple_Stew.webp', 'Northern Apple Stew', 'A dish with braised meat and apples. The meat goes down smooth, its flavor dense, and when cut open, the meat juice that flows out bears traces of apple flavoring. An eye-popping, refreshing dish indeed.', '17.1', 'Mondstadt', '99', '300'),
('14', 'Item_Radish_Veggie_Soup.webp', 'Radish Veggie Soup', 'Radish-based vegetable soup. The clear aromas are perfectly accompanied by a sunny summer afternoon.', '13.9', 'Mondstadt', '99', '300'),
('15', 'Item_Satisfying_Salad.webp', 'Satisfying Salad', 'A vegetable salad. Not just steamed potatoes and fresh vegetables, but also a hard-boiled egg to top it off. Satisfying to both the eyes and stomach.', '15.7', 'Mondstadt', '99', '300'),
('16', 'Item_Sticky_Honey_Roast.webp', 'Sticky Honey Roast', 'A meat dish in a sweet honey sauce. The carrots take the gamey edge off the meat, and the sauce brings it all together sweetly. The perfect warm dish for a cold winter night.', '14.4', 'Mondstadt', '99', '300'),
('17', 'Item_Tea_Break_Pancake.webp', 'Tea Break Pancake', 'A stack of round pancakes. Tender and fluffy, the sweet-smelling pancakes taste like clouds. A heavenly delicacy, no doubt.', '16.9', 'Mondstadt', '99', '300'),
('18', 'Item_Wolfhook_Juice.webp', 'Wolfhook Juice', 'A freshly squeezed, fashionable, and fruity non-alcoholic beverage. Iced Wolfhook juice mixed with a pinch of other ingredients, forming a dreamy shade of violet.', '18.2', 'Mondstadt', '99', '300'),

('19', 'Item_Adeptus_Temptation.webp', 'Adeptus\' Temptation', 'A complex, famous type of Liyue cuisine, in which specially selected ingredients are submerged and slowly bowled into soup stock. The recipe scribbled from memory alone was enough to urge the adepti to once again return to the world of men.', '18.4', 'Liyue', '99', '300'),
('20', 'Item_Almond_Tofu.webp', 'Almond Tofu', 'A dessert made out of almond. It has a silky-smooth texture with a long-lasting aroma of almond. It\'s named tofu only because of its tofu-like shape.', '10.8', 'Liyue', '99', '300'),
('21', 'Item_Black-Back_Perch_Stew.webp', 'Black-Back Perch Stew', 'A poached fish dish. The fresh and tasty fish fillets are tender and juicy. The secret to this recipe is adding powdered Violetgrass into the heated oil to give the dish that aromatic scent. It\'s spicy, but not too spicy.', '12.7', 'Liyue', '99', '300'),
('22', 'Item_Bountiful_Year.webp', 'Bountiful Year', 'Luxurious and exquisite raw fish. The fish is sliced thinly and arranged in the shape of a flower before a ring of side dishes is set all around it. Normally, the side dishes will be mixed with the raw fish according to one\'s taste before consumption — this act is said to ensure that things will be smooth sailing in the coming days.', '19.2', 'Liyue', '99', '300'),
('23', 'Item_Chenyu_Brew.webp', 'Chenyu Brew', 'Common Liyue tea. Sometimes, one might compare life to the sweet aftertaste savored upon sipping a cup of tea.', '15.1', 'Liyue', '99', '300'),
('24', 'Item_Cured_Pork_Dry_Hotpot.webp', 'Cured Pork Dry Hotpot', 'A dish fried over a great flame. Matsutake and Ham have been sliced up, stir-fried, and garnished with some spicy condiments. The flavor of the Ham is a match for the Matsutake\'s crispness, and the combination grows even lovelier and more addictive as you chew. The heat-conducting wok also serves to keep it piping hot for long periods.', '13.6', 'Liyue', '99', '300'),
('25', 'Item_Dragon_Beard_Noodles.webp', 'Dragon Beard Noodles', 'Noodles that are as slender as the hairs on a dragon\'s beard. The slim noodles are as a waterfall, draping their way into a soup that has captured the very essence of the mountains themselves. The softer mouthfeel compared to the average noodle dish make it nigh impossible to stop eating once you\'ve started.', '17.5', 'Liyue', '99', '300'),
('26', 'Item_Fullmoon_Egg.webp', 'Fullmoon Egg', 'One of Liyue\'s traditional snacks. The egg has been beaten into the flour to form a dough and the shrimp and fish have been diced, minced, and packaged into the shape of a teacup, before being garnished with whole shrimp and steamed in a pot. The resulting design is like that of clouds embracing the moon, hence the name Fullmoon Egg.', '11.4', 'Liyue', '99', '300'),
('27', 'Item_Golden_Shrimp_Balls.webp', 'Golden Shrimp Balls', 'A deep-fried shrimp dish. The aroma assaults your senses, while the crispy potatoes bring out the light sweetness of the shrimp meat. This, in tandem with its cute, small shape, makes it very enticing indeed.', '14.7', 'Liyue', '99', '300'),
('28', 'Item_Honey_Char_Siu.webp', 'Honey Char Siu', 'A type of roasted meat from Liyue. As the name implies, the marinated meat skewered with a special metal fork is hung above the stove and roasted. The taste of freshly roasted Char Siu is a favorite of many gourmand.', '13.1', 'Liyue', '99', '300'),
('29', 'Item_Jade_Parcels.webp', 'Jade Parcels', 'An exquisite-looking dish. The ham\'s sweetness is locked inside the fresh vegetables, drizzled with a spicy broth. Delicious is an understatement.', '19.9', 'Liyue', '99', '300'),
('30', 'Item_Jueyun_Chili_Chicken.webp', 'Jueyun Chili Chicken', 'Chicken in a dressing, served cold. The way this dish has been prepared captures the succulence of the chicken perfectly. Beneath the glowing gold skin, the meat has a mildly hot flavor.', '16.3', 'Liyue', '99', '300'),
('31', 'Item_Lotus_Flower_Crisp.webp', 'Lotus Flower Crisp', 'One of Liyue\'s traditional snacks. Sweet stuffed lotus wrapped in a crispy, deep-fried crust. Its layers of flower petals unravel perfectly in the palm of your hand.', '11.9', 'Liyue', '99', '300'),
('32', 'Item_Mora_Meat.webp', 'Mora Meat', 'A large hunk of minced meat packaged inside of a pastry. With a crispy crust and tender meat, this legendary delicacy is so succulent that not even Mora laid in front of you could distract you from enjoying it.', '18.6', 'Liyue', '99', '300'),
('33', 'Item_Mint_Salad.webp', 'Mint Salad', 'A fragrant salad dish. Finely chopped Jueyun Chilis blended with a sauce and mixed with Mint leaves. It looks like nothing special, but it has surprisingly potent powers of refreshment and reinvigoration. It is also the perfect palate-cleanser after a greasy, indulgent meal.', '12.8', 'Liyue', '99', '300'),
('34', 'Item_Noodles_with_Mountain_Delicacies.webp', 'Noodles with Mountain Delicacies', 'Noodles in a meat-and-vegetable sauce. The sauce has a rustic flavor, and there\'s a generous amount of it mixed in with the noodles. A humble but enduringly popular dish.', '14.2', 'Liyue', '99', '300'),
('35', 'Item_Oncidium_Tofu.webp', 'Oncidium Tofu', 'A dish that is a test of one\'s knifework. All the ingredients were sliced into ribbons in a single go, and after being washed, they were placed into the broth and cooked till they floated. The resulting flavor is light and fresh, and would not be out of place as a chef\'s recommendation in a Liyue restaurant.', '16.8', 'Liyue', '99', '300'),
('36', 'Item_Qingce_Stir_Fry.webp', 'Qingce Stir Fry', 'A dish cooked over a roaring fire. They say it was originally just a rustic dish that everyone in Qingce Village knew how to make. But quite unexpectedly, its crispy and spicy dishes gained the recognition of people from elsew  here, and thus began to spread throughout the Liyue region.', '10.5', 'Liyue', '99', '300'),
('37', 'Item_Rice_Buns.webp', 'Rice Buns', 'Soft and fluffy buns. The rice and horsetail have been ground into flour and kneaded into dough before being placed into a steaming basket. They can be eaten as-is or with a vegetable filling. Portable and satiating, it is a very popular dish in the Liyue region.', '17.3', 'Liyue', '99', '300'),
('38', 'Item_Universal_Peace.webp', 'Universal Peace', 'Colorful staple food. Maintains perfect balance between soft and fragrant rice and all kinds of carefully selected sweet ingredients. This dish is mainly known for its meaning as a symbol of prosperity and peace, and less so for its taste. However, with such noble ideals behind it, its flavor should not disappoint.', '15.4', 'Liyue', '99', '300'),
('39', 'Item_Vegetarian_Abalone.webp', 'Vegetarian Abalone', 'A vegetarian dish with a rich flavor. The matsutake has been sliced thin and fried till golden before pouring the sauce. The matsutake meat is sumptuous and has flavor to match that of fresh abalone — almost enough to make you think it was the real thing.', '12.5', 'Liyue', '99', '300'),
('40', 'Item_Zhongyuan_Chop_Suey.webp', 'Zhongyuan Chop Suey', 'A seasoned and cooked meat dish. The authentic \"Liyue taste\" of this aromatic dish makes it a comfort food for golden-agers that may bring a tear to their eyes.', '18.1', 'Liyue', '99', '300'),
('41', 'Item_Stone_Harbor_Delicacies.webp', 'Stone Harbor Delicacies', 'Wok-fried vegetarian food. A stir-fried selection of three ingredients hailing from Liyue. Though the methodology is simple, it brings out the intense, innate flavors of the ingredients, and does not fade in brilliance when compared to some high-class delicacy.', '13.4', 'Liyue', '99', '300'),
('42', 'Item_Tea-Smoked_Squab.webp', 'Tea-Smoked Squab', 'A very popular dish. Squab is marinated in tea and sauce overnight before being dried and deep-fried, suffusing the meat with the wonderful aroma of tea. This technique has been passed down for many years and is a banquet delicacy.', '19.7', 'Liyue', '99', '300'),

('43', 'Item_Berry_Mizu_Manjuu.webp', 'Berry Mizu Manjuu', 'A crystal-clear snack. The transparent skin wraps the yellow filling. It is said that some vendors will put these snacks into a small clay bowl and immerse it in water to ensure that the cool mouthfeel is retained. This dish is as transparent as water, but it will not be washed away by flowing water — this is probably the origin of the name.', '17.6', 'Inazuma', '99', '300'),
('44', 'Item_Crab_Roe_Kourayaki.webp', 'Crab Roe Kourayaki', 'A crab meat dish that has been cooked directly over the flames. The meat and roe are mixed evenly, before being garnished with plump crab legs. The happiness that flows forth from that first bite imparts meaning upon your prior forbearance.', '18.9', 'Inazuma', '99', '300'),
('45', 'Item_Dango_Milk.webp', 'Dango Milk', 'A creative snack made by adding sticky dango to milk. It is sweet and has a dense mouthfeel. All the customers who have tried it love it. Still, it is dango that\'s been added in — drink too much and you might lose your appetite.', '13.7', 'Inazuma', '99', '300'),
('46', 'Item_Egg_Roll.webp', 'Egg Roll', 'A fried egg dish. Beat eggs well, season and fry them slowly in a wok, roll up into a fixed shape. Pour our egg liquid in again and continue until it has all reached a certain thickness, then get ready to plate up. This is an ordinary yet welcoming Inazuman delicacy.', '11.9', 'Inazuma', '99', '300'),
('47', 'Item_Five_Pickled_Treasures.webp', 'Five Pickled Treasures', 'Pickled vegetables. The fermentation process has added a layer of flavor to the natural sweetness of the ingredients. The crispy texture is a real highlight, and it spices up rice and wine alike exceptionally. A treasure indeed!', '12.3', 'Inazuma', '99', '300'),
('48', 'Item_Grilled_Unagi_Fillet.webp', 'Grilled Unagi Fillet', 'A grilled dish. The fat oils sizzle all across the meat\'s surface like a flowery prelude. The baptism of charcoal fire and moistening sauce has imparted a delicate softness to the unagi\'s mouthfeel. If you paired this with rice, you\'d be liable to leave not even a single drop of sauce behind.', '19.4', 'Inazuma', '99', '300'),
('49', 'Item_Invigorating_Kitty_Meal.webp', 'Invigorating Kitty Meal', 'This main dish looks rather cute. The simple methodology used to make it has maximized flavor retention in its ingredients. Even cats who usually pay humdrum humanity little mind will surely come running over when they catch a whiff of this. Uh, wait a moment. Was this supposed to attract dogs, too?', '15.2', 'Inazuma', '99', '300'),
('50', 'Item_Katsu_Sandwich.webp', 'Katsu Sandwich', 'A nutritionally-balanced meal. The two bread slices clip a thick-cut katsu slab between them. The fragrant, slightly sweet-and-sour sauce is the key to preventing this meal from being too rich. A brilliant mix of outlander style and local flavor!', '14.8', 'Inazuma', '99', '300'),
('51', 'Item_Mixed_Yakisoba.webp', 'Mixed Yakisoba', 'One of Inazuma\'s common household dishes. One merely needs to stir-fry the noodles and side dishes evenly before serving, making this an easy-to-make and filling dish. It is no wonder, then, that this dish is so sought after among Inazumans.', '12.5', 'Inazuma', '99', '300'),
('52', 'Item_Omelette_Rice.webp', 'Omelette Rice', 'A main dish wrapped up in an egg skin. The evenly beaten egg fluids are fried into half-doneness before being poured out on top of the rice, and tomato ketchup is drizzled over top afterward once it is ready to plate up. They say that this dish was derived from another region, though this version involves a more complicated cooking method.', '18.7', 'Inazuma', '99', '300'),
('53', 'Item_Rice_Cake_Soup.webp', 'Rice Cake Soup', 'Commonly-seen city cuisine. The ingredients have gorged themselves on the soup, making them most enticing indeed. They say that in the first, this dish only had a scant few ingredients, but more were added as time passed, resulting in its present form.', '17.2', 'Inazuma', '99', '300'),
('54', 'Item_Sakura_Mochi.webp', 'Sakura Mochi', 'A delicate and elegant snack. It is surrounded by the fragrance of sakura, and its elegant exterior hides a loveliness that comes forth and disappears in a single instant. In a moment when all is silent, a single taste returns you to the moment when the sakura were as a blizzard all about you.', '10.6', 'Inazuma', '99', '300'),
('55', 'Item_Tricolor_Dango.webp', 'Tricolor Dango', 'A soft, glutinous snack. Glutinous rice has been grown into powder and rolled into a ball before being steamed. The Sakura Bloom and Snapdragon colors lend an extra liveliness to these dango.', '13.9', 'Inazuma', '99', '300'),
('56', 'Item_Udon_Noodles.webp', 'Udon Noodles', 'Highly springy noodles. After several rounds of rising and pulling, the result is silky smooth yet springy noodles. Unlike ramen, which prizes dense flavors, udon noodles use light flavors to heal the Inazuman soul.', '15.6', 'Inazuma', '99', '300'),
('57', 'Item_Wakatakeni.webp', 'Wakatakeni', 'A light-colored vegetarian dish. Broth is first poured into the pot before the bamboo shoots, and then the seaweed, are added in. The result is an elegant product with a light mouthfeel that agrees well with all palates. Suitable as a pre-meal appetizer or as a side to a main dish.', '11.4', 'Inazuma', '99', '300')
";

// Execute the query
if (mysqli_query($conn, $sql)) {
    echo "New products added successfully <br>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$sql
mysqli_close($conn);
?>