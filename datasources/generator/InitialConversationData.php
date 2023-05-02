<?php
use BlueFission\Framework\Datasource\Generator;
use BlueFission\DevString;

use App\Domain\Conversation\Models\LanguageModel;
use App\Domain\Conversation\DialogueType;
use App\Domain\Conversation\Models\CredentialStatusModel;
use App\Domain\Conversation\CredentialStatus;
use App\Domain\Conversation\Models\TopicModel;
use App\Domain\Conversation\Models\DialogueModel;
use App\Domain\Conversation\Models\DialogueTypeModel;
use App\Domain\Conversation\Models\TagModel;
use App\Domain\Conversation\Models\TopicToTagsPivot;
use App\Domain\Conversation\Models\TopicRouteModel;
use App\Domain\Conversation\Models\EntityTypeModel;
use App\Domain\Conversation\Models\EntityModel;
use App\Domain\Conversation\Models\EntityToTagsPivot;
use App\Domain\Conversation\Models\EntityToEntityTypesPivot;
use App\Domain\Conversation\Fact;
use App\Domain\Conversation\Models\FactTypeModel;
use App\Domain\Conversation\Models\FactModel;
use App\Domain\Conversation\Models\VerbModel;

class InitialConversationData extends Generator
{
	public function populate() {
		$languages = [
			'English (American)',
		];

		$language = new LanguageModel();

		foreach ( $languages as $label ) {
			$language->clear();
			$language->name = strtolower($label);
			$language->label = $label;
			$language->write();
			echo "Creating language: {$language->label} ";
			echo $language->status()."\n";
		}

		$language->clear();
		$language->name = strtolower($languages[0]);
		$language->read();

		$types = [
			'Statement'=>DialogueType::STATEMENT,
			'Query'=>DialogueType::QUERY,
			'Response'=>DialogueType::RESPONSE,
			'Affirmation'=>DialogueType::AFFIRMATION,
			'Negation'=>DialogueType::NEGATION,
			'Complex'=>DialogueType::COMPLEX,
			'Abstract'=>DialogueType::ABSTRACT,
		];

		$type = new DialogueTypeModel();
		foreach ( $types as $label=>$name ) {
			$type->clear();
			$type->name = $name;
			$type->label = $label;
			$type->write();
			echo "Creating dialogue type: {$type->label} ";
			echo $type->status()."\n";
		}

		$sampleDialogue = include OPUS_ROOT.'common/config/nlp/dialogue.php';

$tags =
"abrupt
acidic
adorable
amiable
amused
average
batty
bored
brave
bright
broad
charming
cheeky
cheerful
chubby
clean
clear
cloudy
crooked
cruel
cumbersome
curved
cynical
dangerous
dashing
decayed
deceitful
deep
defeated
dizzy
drab
drained
dull
eager
elegant
emaciated
embarrassed
enchanting
energetic
fancy
fantastic
fierce
filthy
flat
floppy
fluttering
foolish
frantic
fresh
friendly
gentle
ghastly
giddy
gigantic
glamorous
gleaming
glorious
gorgeous
graceful
greasy
grieving
gritty
grotesque
healthy
helpful
helpless
high
hollow
homely
horrific
huge
hungry
hurt
icy
ideal
irritable
itchy
jealous
jittery
jolly
icy
ideal
jolly
joyous
juicy
jumpy
kind
lethal
lucky
ludicrous
macho
narrow
nasty
naughty
nervous
nutty
perfect
perplexed
petite
petty
plain
pleasant
poised
pompous
precious
prickly
proud
pungent
puny
quaint
reassured
relieved
repulsive
responsive
ripe
robust
rotten
rotund
rough
round
salty
sarcastic
scant
shaggy
shaky
shallow
sharp
shiny
short
silky
silly
skinny
slimy
slippery
tasty
teeny
tender
tense
terrible
testy
thankful
thick
tight
timely
tricky
trite
weary
zany
zealous
zippy
people
history
way
art
world
information
map
two
family
government
health
system
computer
meat
year
thanks
music
person
reading
method
data
food
understanding
theory
law
bird
literature
problem
software
control
knowledge
power
ability
economics
love
internet
television
science
library
nature
fact
product
idea
temperature
investment
area
society
activity
story
industry
media
thing
oven
community
definition
safety
quality
development
language
management
player
variety
video
week
security
country
exam
movie
organization
equipment
physics
analysis
policy
series
thought
basis
boyfriend
direction
strategy
technology
army
camera
freedom
paper
environment
child
instance
month
truth
marketing
university
writing
article
department
difference
goal
news
audience
fishing
growth
income
marriage
user
combination
failure
meaning
medicine
philosophy
teacher
communication
night
chemistry
disease
disk
energy
nation
road
role
soup
advertising
location
success
addition
apartment
education
math
moment
painting
politics
attention
decision
event
property
shopping
student
wood
competition
distribution
entertainment
office
population
president
unit
category
cigarette
topic
introduction
opportunity
performance
driver
flight
length
magazine
newspaper
relationship
teaching
cell
dealer
finding
lake
member
message
phone
scene
appearance
association
concept
customer
death
discussion
housing
inflation
insurance
mood
woman
advice
blood
effort
expression
importance
opinion
payment
reality
responsibility
situation
skill
statement
wealth
application
city
county
depth
estate
foundation
grandmother
heart
perspective
photo
recipe
studio
topic
collection
depression
imagination
passion
percentage
resource
setting
ad
agency
college
connection
criticism
debt
description
memory
patience
secretary
solution
administration
aspect
attitude
director
personality
psychology
recommendation
response
selection
storage
version
alcohol
argument
complaint
contract
emphasis
highway
loss
membership
possession
preparation
steak
union
agreement
cancer
currency
employment
engineering
entry
interaction
mixture
preference
region
republic
tradition
virus
actor
classroom
delivery
device
difficulty
drama
election
engine
football
guidance
hotel
owner
priority
protection
suggestion
tension
variation
anxiety
atmosphere
awareness
bath
bread
candidate
climate
comparison
confusion
construction
elevator
emotion
employee
employer
guest
height
leadership
mall
manager
operation
recording
sample
transportation
charity
cousin
disaster
editor
efficiency
excitement
extent
feedback
guitar
homework
leader
mom
outcome
permission
presentation
promotion
reflection
refrigerator
resolution
revenue
session
singer
tennis
basket
bonus
cabinet
childhood
church
clothes
coffee
dinner
drawing
hair
hearing
initiative
judgment
lab
measurement
mode
mud
orange
poetry
police
possibility
procedure
queen
ratio
relation
restaurant
satisfaction
sector
signature
significance
song
tooth
town
vehicle
volume
wife
accident
airport
appointment
arrival
assumption
baseball
chapter
committee
conversation
database
enthusiasm
error
explanation
farmer
gate
girl
hall
historian
hospital
injury
instruction
maintenance
manufacturer
meal
perception
pie
poem
presence
proposal
reception
replacement
revolution
river
son
speech
tea
village
warning
winner
worker
writer
assistance
breath
buyer
chest
chocolate
conclusion
contribution
cookie
courage
dad
desk
drawer
establishment
examination
garbage
grocery
honey
impression
improvement
independence
insect
inspection
inspector
king
ladder
menu
penalty
piano
potato
profession
professor
quantity
reaction
requirement
salad
sister
supermarket
tongue
weakness
wedding
affair
ambition
analyst
apple
assignment
assistant
bathroom
bedroom
beer
birthday
celebration
championship
cheek
client
consequence
departure
diamond
dirt
ear
fortune
friendship
funeral
gene
girlfriend
hat
indication
intention
lady
midnight
negotiation
obligation
passenger
pizza
platform
poet
pollution
recognition
reputation
shirt
sir
speaker
stranger
surgery
sympathy
tale
throat
trainer
uncle
youth
time
work
film
water
money
example
while
business
study
game
life
form
air
day
place
number
part
field
fish
back
process
heat
hand
experience
job
book
end
point
type
home
economy
value
body
market
guide
interest
state
radio
course
company
price
size
card
list
mind
trade
line
care
group
risk
word
fat
force
key
light
training
name
school
top
amount
level
order
practice
research
sense
service
piece
web
boss
sport
fun
house
page
term
test
answer
sound
focus
matter
kind
soil
board
oil
picture
access
garden
range
rate
reason
future
site
demand
exercise
image
case
cause
coast
action
age
bad
boat
record
result
section
building
mouse
cash
class
nothing
period
plan
store
tax
side
subject
space
rule
stock
weather
chance
figure
man
model
source
beginning
earth
program
chicken
design
feature
head
material
purpose
question
rock
salt
act
birth
car
dog
object
scale
sun
note
profit
rent
speed
style
war
bank
craft
half
inside
outside
standard
bus
exchange
eye
fire
position
pressure
stress
advantage
benefit
box
frame
issue
step
cycle
face
item
metal
paint
review
room
screen
structure
view
account
ball
discipline
medium
share
balance
bit
black
bottom
choice
gift
impact
machine
shape
tool
wind
address
average
career
culture
morning
pot
sign
table
task
condition
contact
credit
egg
hope
ice
network
north
square
attempt
date
effect
link
post
star
voice
capital
challenge
friend
self
shot
brush
couple
debate
exit
front
function
lack
living
plant
plastic
spot
summer
taste
theme
track
wing
brain
button
click
desire
foot
gas
influence
notice
rain
wall
base
damage
distance
feeling
pair
savings
staff
sugar
target
text
animal
author
budget
discount
file
ground
lesson
minute
officer
phase
reference
register
sky
stage
stick
title
trouble
bowl
bridge
campaign
character
club
edge
evidence
fan
letter
lock
maximum
novel
option
pack
park
plenty
quarter
skin
sort
weight
baby
background
carry
dish
factor
fruit
glass
joint
master
muscle
red
strength
traffic
trip
vegetable
appeal
chart
gear
ideal
kitchen
land
log
mother
net
party
principle
relative
sale
season
signal
spirit
street
tree
wave
belt
bench
commission
copy
drop
minimum
path
progress
project
sea
south
status
stuff
ticket
tour
angle
blue
breakfast
confidence
daughter
degree
doctor
dot
dream
duty
essay
father
fee
finance
hour
juice
limit
luck
milk
mouth
peace
pipe
seat
stable
storm
substance
team
trick
afternoon
bat
beach
blank
catch
chain
consideration
cream
crew
detail
gold
interview
kid
mark
match
mission
pain
pleasure
score
screw
sex
shop
shower
suit
tone
window
agent
band
block
bone
calendar
cap
coat
contest
corner
court
cup
district
door
east
finger
garage
guarantee
hole
hook
implement
layer
lecture
lie
manner
meeting
nose
parking
partner
profile
respect
rice
routine
schedule
swimming
telephone
tip
winter
airline
bag
battle
bed
bill
bother
cake
code
curve
designer
dimension
dress
ease
emergency
evening
extension
farm
fight
gap
grade
holiday
horror
horse
host
husband
loan
mistake
mountain
nail
noise
occasion
package
patient
pause
phrase
proof
race
relief
sand
sentence
shoulder
smoke
stomach
string
tourist
towel
vacation
west
wheel
wine
arm
aside
associate
bet
blow
border
branch
breast
brother
buddy
bunch
chip
coach
cross
document
draft
dust
expert
floor
god
golf
habit
iron
judge
knife
landscape
league
mail
mess
native
opening
parent
pattern
pin
pool
pound
request
salary
shame
shelter
shoe
silver
tackle
tank
trust
assist
bake
bar
bell
bike
blame
boy
brick
chair
closet
clue
collar
comment
conference
devil
diet
fear
fuel
glove
jacket
lunch
monitor
mortgage
nurse
pace
panic
peak
plane
reward
row
sandwich
shock
spite
spray
surprise
till
transition
weekend
welcome
yard
alarm
bend
bicycle
bite
blind
bottle
cable
candle
clerk
cloud
concert
counter
flower
grandfather
harm
knee
lawyer
leather
load
mirror
neck
pension
plate
purple
ruin
ship
skirt
slice
snow
specialist
stroke
switch
trash
tune
zone
anger
award
bid
bitter
boot
bug
camp
candy
carpet
cat
champion
channel
clock
comfort
cow
crack
engineer
entrance
fault
grass
guy
hell
highlight
incident
island
joke
jury
leg
lip
mate
motor
nerve
passage
pen
pride
priest
prize
promise
resident
resort
ring
roof
rope
sail
scheme
script
sock
station
toe
tower
truck
witness
a
you
it
can
will
if
one
many
most
other
use
make
good
look
help
go
great
being
few
might
still
public
read
keep
start
give
human
local
general
she
specific
long
play
feel
high
tonight
put
common
set
change
simple
past
big
possible
particular
today
major
personal
current
national
cut
natural
physical
show
try
check
second
call
move
pay
let
increase
single
individual
turn
ask
buy
guard
hold
main
offer
potential
professional
international
travel
cook
alternative
following
special
working
whole
dance
excuse
cold
commercial
low
purchase
deal
primary
worth
fall
necessary
positive
produce
search
present
spend
talk
creative
tell
cost
drive
green
support
glad
remove
return
run
complex
due
effective
middle
regular
reserve
independent
leave
original
reach
rest
serve
watch
beautiful
charge
active
break
negative
safe
stay
visit
visual
affect
cover
report
rise
walk
white
beyond
junior
pick
unique
anything
classic
final
lift
mix
private
stop
teach
western
concern
familiar
fly
official
broad
comfortable
gain
maybe
rich
save
stand
young
fail
heavy
hello
lead
listen
valuable
worry
handle
leading
meet
release
sell
finish
normal
press
ride
secret
spread
spring
tough
wait
brown
deep
display
flow
hit
objective
shoot
touch
cancel
chemical
cry
dump
extreme
push
conflict
eat
fill
formal
jump
kick
opposite
pass
pitch
remote
total
treat
vast
abuse
beat
burn
deposit
print
raise
sleep
somewhere
advance
anywhere
consist
dark
double
draw
equal
fix
hire
internal
join
kill
sensitive
tap
win
attack
claim
constant
drag
drink
guess
minor
pull
raw
soft
solid
wear
weird
wonder
annual
count
dead
doubt
feed
forever
impress
nobody
repeat
round
sing
slide
strip
whereas
wish
combine
command
dig
divide
equivalent
hang
hunt
initial
march
mention
smell
spiritual
survey
tie
adult
brief
crazy
escape
gather
hate
prior
repair
rough
sad
scratch
sick
strike
employ
external
hurt
illegal
laugh
lay
mobile
nasty
ordinary
respond
royal
senior
split
strain
struggle
swim
train
upper
wash
yellow
convert
crash
dependent
fold
funny
grab
hide
miss
permit
quote
recover
resolve
roll
sink
slip
spare
suspect
sweet
swing
twist
upstairs
usual
abroad
brave
calm
concentrate
estimate
grand
male
mine
prompt
quiet
refuse
regret
reveal
rush
shake
shift
shine
steal
suck
surround
anybody
bear
brilliant
dare
dear
delay
drunk
female
hurry
inevitable
invite
kiss
neat
pop
punch
quit
reply
representative
resist
rip
rub
silly
smile
spell
stretch
stupid
tear
temporary
tomorrow
wake
wrap
yesterday";

		$topic = new TopicModel();
		$tag = new TagModel();
		$topicTags = new TopicToTagsPivot();
		$dialogue = new DialogueModel();
		$route = new TopicRouteModel();

		$tagArray = explode("\n", $tags);
		foreach ( $tagArray as $item ) {
			$tag->clear();
			$tag->label = trim($item);
			$tag->read();
			if ( !$tag->id() ) {
				$tag->write();
				echo "Creating tag: {$tag->label} ";
				echo $tag->status()."\n";
			}
		}

		foreach ( $sampleDialogue as $from=>$info ) {
			$topic->clear();
			$topic->name = strtolower($from);
			$topic->label = $from;
			$topic->weight = 1;
			$topic->read();
			if ( !$topic->id() ) {
				$topic->write();
				echo "Creating topic: {$topic->label} ";
				echo $topic->status()."\n";

				$topic->read();
			}
			$cid = $topic->id();


			$topics = $info[0];
			foreach ( $topics as $to ) {
				$topic->clear();
				$topic->name = strtolower($to);
				$topic->label = $to;
				$topic->weight = 1;
				$topic->read();

				if ( !$topic->id() ) {
					$topic->write();
					echo "Creating topic: {$topic->label} ";
					echo $topic->status()."\n";

					$topic->read();
				}

				$route->clear();
				$route->from = $cid;
				$route->to = ($from == $to) ? $cid : $topic->id();
				$route->weight = 1;
				$route->write();
				echo "Creating route: {$route->from} -> {$route->to} ";
				echo $route->status()."\n";
			}

			foreach ( $info[1] as $text ) {
				$type->clear();
				$typeName = DialogueType::RESPONSE;
				if (strpos($text, '?')) {
					$typeName = DialogueType::QUERY;
				} elseif ( $from == 'because' || $from == 'for example' ) {
					$typeName = DialogueType::STATEMENT;
				}

				$type->name = $typeName;
				$type->read();

				$dialogue->clear();
				$dialogue->dialogue_type_id = $type->id();
				$dialogue->language_id = $language->id();
				$dialogue->topic_id = $cid;
				$dialogue->text = $text;
				$dialogue->weight = 1;

				// $data = $cid;
				// die(var_dump($data));
				$dialogue->write();
				echo "Creating dialogue: {$dialogue->text} ";
				echo $dialogue->status()."\n";
			}

			foreach ( $info[2] as $label ) {
				$tag->clear();
				$tag->label = $label;
				$tag->read();
				if ( !$tag->id() ) {
					$tag->write();
					$tag->read();
				}

				$topicTags->clear();
				$topicTags->topic_id = $cid;
				$topicTags->tag_id = $tag->id();
				$topicTags->weight = 1;
				$topicTags->write();
				echo "Creating topic tag: {$topicTags->topic_id} -> {$topicTags->tag_id} ";
				echo $topicTags->status()."\n";
			}
		}

		// https://www.talkenglish.com/vocabulary/top-1500-nouns.aspx
		$entityList =
			['time'=>['when','now','then','second','minute','hour','moment','morning','afternoon','evening','day','night','week','weekend','month','year','decade','century','millenium','aeon','yesterday','today','tomorrow','never','always'],
			'agent'=>['who','agent','person','people','woman','man','girl','boy','child','adult','friend','stranger','user','visitor','student','mother','father','member','president','kid','parent','others','guy','teacher'], 
			'way'=>['how','way','method','manner','process','route','path','life','problem','case','system','program','right','issue','service'],
			'thing'=>['what','computer','machine','life','state','problem','hand','part','case','system','program','question','number','letter','point','water','money','story','fact','right','book','eye','word','issue','side','kind','head','house','service','power','game','line','end','law','car','name','idea','body','face','level','door','health','result','change','research','air','force','history'], 
			'place'=>['where','world','school','state','country','place','point','home','room','area','lot','study','side','house','end','city','level','office','party'], 
			'activity'=>['education','school','question','work','point','study','job','activity','end','party','change','research','teach'], 
			'organization'=>['organization','school','state','family','group','country','company','system','government','business','house','community','team','others','office','party','force','people'],
			'color'=>['color','grey','pink','beige','tan','peach','turquoise','indigo','violet','white','yellow','blue','red','green','black','brown','azure','ivory','teal','silver','purple','navy blue','pea green','gray','orange','maroon','charcoal','aquamarine','coral','fuchsia','wheat','lime','crimson','khaki','hot pink','magenta','olden','plum','olive','cyan'],
			'shape'=>['shape','circle','oval','elipse','square','rectangle','triangle','rhombus','diamond','trapezium','pentagon','hexagon','octagon','cylinder','cone','cube','cuboid','prism','pyramid','sphere','tetrahedron','octahedron','icosahedron','dodecahedron','tesseract','amorphous'],
		];

		$entityType = new EntityTypeModel();
		$entity = new EntityModel();
		$entityTags = new EntityToTagsPivot();
		$entityEntityTypes = new EntityToEntityTypesPivot();

		foreach ($entityList as $type=>$entities) {
			$entityType->clear();
			$entityType->name = $type;
			$entityType->label = ucwords($type);
			$entityType->write();
			echo "Creating entity type: {$entityType->label} ";
			echo $entityType->status()."\n";
			$entityType->read();

			foreach ($entities as $ent) {
				$entity->clear();
				$entity->name = $ent;
				$entity->label = ucwords($ent);
				$entity->read();
				if ( !$entity->id() ) {
					$entity->write();
					echo "Creating entity: {$entity->label} ";
					echo $entity->status()."\n";

					$entity->read();
				}

				$entityEntityTypes->clear();
				$entityEntityTypes->entity_type_id = $entityType->id();
				$entityEntityTypes->entity_id = $entity->id();
				$entityEntityTypes->weight = 1;
				$entityEntityTypes->write();
				echo "Creating entity type: {$entityEntityTypes->entity_type_id} -> {$entityEntityTypes->entity_id} ";
				echo $entityEntityTypes->status()."\n";
			}
		}

		$verb = new VerbModel();

		$verbs = ['be','do','have','come','go','see','seem','give','take','keep','make','put','send','say','let','get'];
		foreach ( $verbs as $action ) {
			$verb->clear();
			$verb->name = $action;
			$verb->label = ucwords($action);
			$verb->write();
			echo "Creating verb: {$verb->label} ";
			echo $verb->status()."\n";
		}

		$factTypes = [
			'Like'=>Fact::LIKE,
			'Is'=>Fact::IS,
			'Needs'=>Fact::NEEDS,
			'Might'=>Fact::MIGHT,
			'Will'=>Fact::WILL,
			'Can'=>Fact::CAN,
			'Shall'=>Fact::SHALL,
			'Must'=>Fact::MUST,
			'Has'=>Fact::HAS,
			'Does'=>Fact::DOES,
		];

		$factType = new FactTypeModel();

		foreach ( $factTypes as $label=>$name ) {
			$factType->clear();
			$factType->name = $name;
			$factType->label = $label;
			$factType->write();
			echo "Creating fact type: {$factType->label} ";
			echo $factType->status()."\n";
		}

		$facts = [
			['self',Fact::IS,'bot',true],
		];

		$fact = new FactModel();
		foreach ( $facts as $item ) {
			$factType->clear();
			$factType->name = $item[1];
			$factType->read();

			$fact->clear();
			$fact->fact_type_id = $factType->id();
			$fact->is_negated = $item[3] ? 0 : 1;
			$fact->var = $item[0];
			$fact->value = $item[2];
			$fact->privilege = 1;
			$fact->ttl = 525960; // 1 year in minutes
			$fact->write();
			echo "Creating fact: {$fact->var} {$fact->fact_type_id} {$fact->value} ";
			echo $fact->status()."\n";
		}
	}
}