/* permission table */
CREATE TABLE Permission (
    id int NOT NULL,
    description varchar(255) NOT NULL,
    p_type varchar(120),
    CONSTRAINT PK_Permission PRIMARY KEY (id)
);

/* permission id auto increment */
CREATE SEQUENCE permissionid START WITH 1;

CREATE OR REPLACE trigger permission_ID 
BEFORE INSERT ON permission 
FOR EACH ROW

BEGIN
  SELECT permissionid.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/
/* end permission table */

/* person table */
CREATE TABLE Person (
    id int NOT NULL,
    surname varchar(120) NOT NULL,
    name varchar(120),
	password varchar(255),
    permissionId int,
	email varchar(80),
	pp varchar(50),
	birthdate, date
	CONSTRAINT FK_PermissionId FOREIGN KEY (permissionId)
    REFERENCES Permission,
    CONSTRAINT PK_Person PRIMARY KEY (id),
	CONSTRAINT Email_unique UNIQUE (email)
);	

/* person id auto increment */
CREATE SEQUENCE personid START WITH 1;

CREATE OR REPLACE trigger person_ID 
BEFORE INSERT ON person 
FOR EACH ROW

BEGIN
  SELECT personid.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/
/* end person table */

/* author table */
CREATE TABLE Author(
	personID int,
	signature varchar(255),
	CONSTRAINT FK_Author FOREIGN KEY (personID) REFERENCES Person (id) ON DELETE CASCADE,
	CONSTRAINT PK_Author PRIMARY KEY (personId)
);
/* end author table */

/* user table */
CREATE TABLE User_ (
	personID int,
	username varchar(255) ,
	gender char,
	CONSTRAINT FK_User FOREIGN KEY (personID) REFERENCES Person (id) ON DELETE CASCADE,
	CONSTRAINT PK_User PRIMARY KEY (personId)
);
/* end user table */

/* person permission table */
CREATE TABLE Person_permission (
	p_id int,
	personID int,
	CONSTRAINT FK_Permission FOREIGN KEY (p_id) REFERENCES Permission (id) ON DELETE CASCADE,
	CONSTRAINT FK_PersonPer FOREIGN KEY (personID) REFERENCES Person (id) ON DELETE CASCADE,
	CONSTRAINT PK_PersonPermission PRIMARY KEY (p_id,personID)
);
/* end person permission */

/* category table */
CREATE TABLE Category (
	id int,
	name varchar(255),
	CONSTRAINT PK_Category PRIMARY KEY (id)
);

/* category id auto increment */
CREATE SEQUENCE categoryid START WITH 1;

CREATE OR REPLACE trigger category_ID 
BEFORE INSERT ON category 
FOR EACH ROW

BEGIN
  SELECT categoryid.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/
/* end category */

/* news table */
CREATE TABLE News (
	id int,
	title varchar(255),
	description varchar(4000),
	visible int,
	CONSTRAINT PK_News PRIMARY KEY (id)
);

/* news id auto increment */
CREATE SEQUENCE newsid START WITH 1;

CREATE OR REPLACE trigger news_ID 
BEFORE INSERT ON news 
FOR EACH ROW

BEGIN
  SELECT newsid.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/
/* end news table */

/* author news */
CREATE TABLE Author_News (
	authorId int,
	newsId int,
	newsDate date,
	CONSTRAINT FK_anews FOREIGN KEY (authorId) REFERENCES Author(PersonId) ON DELETE CASCADE,
	CONSTRAINT FK_news FOREIGN KEY (newsId) REFERENCES News (id) ON DELETE CASCADE,
	CONSTRAINT PK_AuthorNews PRIMARY KEY (authorID,newsID,newsDate)
);
/* end authornews */

/*news category*/
CREATE TABLE News_Category (
	newsID int,
	categoryId int,
	CONSTRAINT FK_categorynews FOREIGN KEY (categoryId) REFERENCES Category(id) ON DELETE CASCADE,
	CONSTRAINT FK_newsCat FOREIGN KEY (newsId) REFERENCES News (id) ON DELETE CASCADE,
	CONSTRAINT PK_NewsCategory PRIMARY KEY (newsID,categoryId)
);
/* end news category */

/* category_manage */
CREATE TABLE Category_Manage (
	authorID int,
	categoryID int,
	CONSTRAINT FK_categorymanage FOREIGN KEY (categoryId) REFERENCES Category(id) ON DELETE CASCADE,
	CONSTRAINT FK_authormanage FOREIGN KEY (authorID) REFERENCES Author (PersonId) ON DELETE CASCADE,
	CONSTRAINT PK_CategoryManage PRIMARY KEY (authorID,categoryId)
);
/* end category manage */

/* news comment */
CREATE TABLE News_Comment (
	userId int,
	newsId int, 
	content varchar(255),
	Com_date date,
	CONSTRAINT FK_commentuser FOREIGN KEY (userId) REFERENCES User_(personID) ON DELETE CASCADE,
	CONSTRAINT FK_commentnews FOREIGN KEY (newsID) REFERENCES News (id) ON DELETE CASCADE,
	CONSTRAINT PK_Comment PRIMARY KEY (userId,newsID,com_date)
);
/* end news comment */

/* emoji type */
CREATE TABLE Emoji_Type (
	id int,
	description varchar(125),
	photoUrl varchar(1000),
	CONSTRAINT PK_EmojiType PRIMARY KEY (id)
);

/* emoji id auto increment */
CREATE SEQUENCE emoji START WITH 1;

CREATE OR REPLACE trigger emoji_ID 
BEFORE INSERT ON emoji_type 
FOR EACH ROW

BEGIN
  SELECT emoji.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/
/* end emoji type */

/* news_emoji */
CREATE TABLE News_Emoji (
	newsID int,
	userId int,
	emojiId int,
	CONSTRAINT FK_personEmoji FOREIGN KEY (userId) REFERENCES User_(personID) ON DELETE CASCADE,
	CONSTRAINT FK_newsEmoji FOREIGN KEY (newsID) REFERENCES News (id) ON DELETE CASCADE,
	CONSTRAINT FK_emojitype FOREIGN KEY (emojiId) REFERENCES Emoji_Type(id) ON DELETE CASCADE,
	CONSTRAINT PK_News_Emoji PRIMARY KEY (userId,newsID,emojiId)
);
/* end news emoji */

/* admin table */
CREATE TABLE Admin (
	id int,
	email varchar(70),
	password varchar(255),
	CONSTRAINT PK_Admin PRIMARY KEY (id)
);
/* admin id auto increment */
CREATE SEQUENCE adminid START WITH 1;

CREATE OR REPLACE trigger admin_ID 
BEFORE INSERT ON admin 
FOR EACH ROW

BEGIN
  SELECT adminid.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/
/*end admin */

/* news photo */
CREATE TABLE news_Photo (
	photoUrl varchar(255),
	newsID int,
	authorID int,
	CONSTRAINT FK_newsPhotoAuth FOREIGN KEY (authorId) REFERENCES Author(personID) ON DELETE CASCADE,
	CONSTRAINT FK_newsPhotoNews FOREIGN KEY (newsID) REFERENCES News (id) ON DELETE CASCADE,
	CONSTRAINT PK_newsphoto PRIMARY KEY (photoUrl,newsID,authorID)
);
/* end news photo */

/* activity */
CREATE TABLE Activity (
	id int,
	description varchar(20),
	CONSTRAINT PK_ActivityType PRIMARY KEY (id)
);
/* activity id auto increment */
CREATE SEQUENCE activityid START WITH 1;

CREATE OR REPLACE trigger activity_ID 
BEFORE INSERT ON activity 
FOR EACH ROW

BEGIN
  SELECT activityid.NEXTVAL
  INTO   :new.id
  FROM   dual;
END;
/
/* end activity*/

/* user activity*/
CREATE TABLE User_activity (
	userId int,
	activityType int,
	acDate DATE,
	CONSTRAINT FK_UserActivity FOREIGN KEY (userId) REFERENCES Person(id) ON DELETE CASCADE,
	CONSTRAINT FK_ActivityTypeuser FOREIGN KEY (activityType) REFERENCES Activity(id) ON DELETE CASCADE,
	CONSTRAINT PK_UserActivity PRIMARY KEY (userId,activityType,acDate)
);
/* end user activity*/

/* admin activity*/
CREATE TABLE Admin_activity (
	adminId int,
	activityType int,
	acDate date,
	CONSTRAINT FK_AdminActivity FOREIGN KEY (adminId) REFERENCES Admin(id) ON DELETE CASCADE,
	CONSTRAINT FK_ActivityTypeAdmin FOREIGN KEY (activityType) REFERENCES Activity(id) ON DELETE CASCADE,
	CONSTRAINT PK_AdminActivity PRIMARY KEY (adminId,activityType,acDate)
);
/*end admin activity */


/*-------------- stored procedures ---------*/

/* permission procedures */
CREATE OR REPLACE PROCEDURE insertPermission(
	   P_TYPE IN Permission.P_type%TYPE,
	   DESCRIPTION IN Permission.DESCRIPTION%TYPE)
IS
BEGIN

  INSERT INTO Permission ("P_TYPE", "DESCRIPTION")
  VALUES (p_type,description);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE updatePermission(
	   p_id IN Permission.id%TYPE,
	   p_P_TYPE IN Permission.P_type%TYPE,
	   p_DESCRIPTION IN Permission.DESCRIPTION%TYPE)
IS
BEGIN

  UPDATE Permission SET P_TYPE = p_P_TYPE , DESCRIPTION=p_DESCRIPTION where id = p_id;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deletePermission(p_id IN Permission.id%TYPE)
IS
BEGIN

  DELETE Permission where id = p_id;

  COMMIT;

END;
/
/* end permission procedures */

/* category procedures */
CREATE OR REPLACE PROCEDURE insertCategory(c_name IN Category.name%TYPE)
IS
BEGIN

  INSERT INTO Category ("NAME")
  VALUES (c_name);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE UpdateCategory(
	   c_id IN Category.id%TYPE,
	   c_name IN Category.name%TYPE)
IS
BEGIN

  UPDATE Category SET name = c_name where id = c_id;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteCategory(c_id IN Category.id%TYPE)
IS
BEGIN

  DELETE Category where id = c_id;

  COMMIT;

END;
/
/* end category procedures */

/* NEWS procedures */
CREATE OR REPLACE PROCEDURE insertNews(n_title IN News.TITLE%TYPE,
									   n_description IN News.DESCRIPTION%TYPE,
									   n_visible IN News.VISIBLE%TYPE)
IS
BEGIN

  INSERT INTO News ("TITLE","DESCRIPTION","VISIBLE")
  VALUES (n_title,n_description,n_visible);

  COMMIT;

END;
/

create or replace PROCEDURE UpdateNews(
	   n_id IN News.id%TYPE,
	   n_title IN News.TITLE%TYPE,
	   n_description IN News.DESCRIPTION%TYPE,
       visibility IN News.VISIBLE%TYPE )
IS
BEGIN

  UPDATE News SET TITLE = n_title, DESCRIPTION=n_description,VISIBLE=visibility where id = n_id;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteNews(n_id IN News.id%TYPE)
IS
BEGIN

  DELETE News where id = n_id;

  COMMIT;

END;
/
/* end NEWS procedures */

/* Author_news procedures */
CREATE OR REPLACE PROCEDURE insertAuthorNews(a_id IN Author_news.AUTHORID%TYPE,
											 n_id IN Author_news.NEWSID%TYPE,
											 n_date IN Author_news.NEWSDATE%TYPE)
IS
BEGIN

  INSERT INTO Author_news ("AUTHORID","NEWSID","NEWSDATE")
  VALUES (a_id,n_id,n_date);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE UpdateAuthorNews(
	   a_id IN Author_news.AUTHORID%TYPE,
	   n_id IN Author_news.NEWSID%TYPE,
	   n_date IN Author_news.NEWSDATE%TYPE,
	   Newdate IN Author_news.NEWSDATE%TYPE)
IS
BEGIN

  UPDATE Author_news SET NEWSDATE = Newdate where AUTHORID = a_id and NEWSID = n_id and NEWSDATE = n_date;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteAuthorNews(a_id IN Author_news.AUTHORID%TYPE,
											 n_id IN Author_news.NEWSID%TYPE,
											 n_date IN Author_news.NEWSDATE%TYPE)
IS
BEGIN

  DELETE Author_news where AUTHORID = a_id and NEWSID = n_id and NEWSDATE = n_date;

  COMMIT;

END;
/
/* end author_news procedures */

/* news_category procedures */
CREATE OR REPLACE PROCEDURE insertnews_category(n_id IN news_category.NEWSID%TYPE,
											 c_id IN news_category.CATEGORYID%TYPE)
IS
BEGIN

  INSERT INTO news_category ("NEWSID","CATEGORYID")
  VALUES (n_id,c_id);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updatenews_category(
	   n_id IN news_category.NEWSID%TYPE,
	   c_id IN news_category.CATEGORYID%TYPE,
	   newn_id IN news_category.NEWSID%TYPE,
	   newc_id IN news_category.CATEGORYID%TYPE)
IS
BEGIN

  UPDATE news_category SET NEWSID = newn_id, CATEGORYID = newc_id where NEWSID = n_id and CATEGORYID = c_id;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deletenews_category(n_id IN news_category.NEWSID%TYPE,
												c_id IN news_category.CATEGORYID%TYPE)
IS
BEGIN

  DELETE news_category where NEWSID = n_id and CATEGORYID = c_id;

  COMMIT;

END;
/
/* end news_category procedures */

/* category_manage procedures */
CREATE OR REPLACE PROCEDURE insertcategory_manage(a_id IN category_manage.AUTHORID%TYPE,
											 c_id IN category_manage.CATEGORYID%TYPE)
IS
BEGIN

  INSERT INTO category_manage ("AUTHORID","CATEGORYID")
  VALUES (a_id,c_id);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updatecategory_manage(
	   a_id IN category_manage.AUTHORID%TYPE,
	   c_id IN category_manage.CATEGORYID%TYPE,
	   newa_id IN category_manage.AUTHORID%TYPE,
	   newc_id IN category_manage.CATEGORYID%TYPE)
IS
BEGIN

  UPDATE category_manage SET AUTHORID = newa_id, CATEGORYID = newc_id where AUTHORID = a_id and CATEGORYID = c_id;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deletecategory_manage(a_id IN category_manage.AUTHORID%TYPE,
												c_id IN category_manage.CATEGORYID%TYPE)
IS
BEGIN

  DELETE category_manage where AUTHORID = a_id and CATEGORYID = c_id;

  COMMIT;

END;
/
/* end category_manage procedures */

/* news_comment procedures */
CREATE OR REPLACE PROCEDURE insertnews_comment(u_id IN news_comment.USERID%TYPE,
											   news_id IN news_comment.NEWSID%TYPE,
											   cont IN news_comment.CONTENT%TYPE,
											   datee IN news_comment.COM_DATE%TYPE)
IS
BEGIN

  INSERT INTO news_comment ("USERID","NEWSID","CONTENT","COM_DATE")
  VALUES (u_id,news_id,cont,datee);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updatenews_comment(u_id IN news_comment.USERID%TYPE,
											   news_id IN news_comment.NEWSID%TYPE,
											   cont IN news_comment.CONTENT%TYPE,
											   datee IN news_comment.COM_DATE%TYPE)
IS
BEGIN

  UPDATE news_comment SET NEWSID = news_id where USERID = u_id and NEWSID = news_id and COM_DATE=datee ;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deletenews_comment(u_id IN news_comment.USERID%TYPE,
											   news_id IN news_comment.NEWSID%TYPE,
											   datee IN news_comment.COM_DATE%TYPE)
IS
BEGIN

  DELETE news_comment where USERID = u_id and NEWSID = news_id and COM_DATE=datee;

  COMMIT;

END;
/
/* end category_manage procedures */

/* emoji_type procedures */
CREATE OR REPLACE PROCEDURE insertemoji_type(  descrip IN emoji_type.DESCRIPTION%TYPE,
											   url IN emoji_type.PHOTOURL%TYPE)
IS
BEGIN

  INSERT INTO emoji_type ("DESCRIPTION","PHOTOURL")
  VALUES (descrip,url);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updateemoji_type(  e_id IN emoji_type.ID%TYPE,
											   descrip IN emoji_type.DESCRIPTION%TYPE,
											   url IN emoji_type.PHOTOURL%TYPE)
IS
BEGIN

  UPDATE emoji_type SET DESCRIPTION = descrip,PHOTOURL=url where ID=e_id;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteemoji_type(e_id IN emoji_type.ID%TYPE)
IS
BEGIN

  DELETE emoji_type where ID=e_id;

  COMMIT;

END;
/
/* end emoji_type procedures */

/* news_emoji procedures */
CREATE OR REPLACE PROCEDURE insertnews_emoji(n_id IN news_emoji.NEWSID%TYPE,
											   u_id IN news_emoji.USERID%TYPE,
											   e_id IN news_emoji.EMOJIID%TYPE)
IS
BEGIN

  INSERT INTO news_emoji ("NEWSID","USERID","EMOJIID")
  VALUES (n_id,u_id,e_id);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updatenews_emoji(  n_id IN news_emoji.NEWSID%TYPE,
											   u_id IN news_emoji.USERID%TYPE,
											   e_id IN news_emoji.EMOJIID%TYPE,
											   ne_id IN news_emoji.EMOJIID%TYPE)
IS
BEGIN

  UPDATE news_emoji SET EMOJIID = ne_id where NEWSID = n_id and USERID=u_id and EMOJIID=e_id ;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deletenews_emoji(n_id IN news_emoji.NEWSID%TYPE,
											   u_id IN news_emoji.USERID%TYPE,
											   e_id IN news_emoji.EMOJIID%TYPE)
IS
BEGIN

  DELETE news_emoji where NEWSID = n_id and USERID=u_id and EMOJIID=e_id ;
  COMMIT;

END;
/
/* end news_emoji procedures */

/* news_photo procedures */
CREATE OR REPLACE PROCEDURE insertnews_photo(url IN news_photo.PHOTOURL%TYPE,
											   n_id IN news_photo.NEWSID%TYPE,
											   e_id IN news_photo.AUTHORID%TYPE)
IS
BEGIN

  INSERT INTO news_photo ("PHOTOURL","NEWSID","AUTHORID")
  VALUES (url,n_id,e_id);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updatenews_photo(url IN news_photo.PHOTOURL%TYPE,
											   nurl IN news_photo.PHOTOURL%TYPE,
											   n_id IN news_photo.NEWSID%TYPE,
											   e_id IN news_photo.AUTHORID%TYPE)
IS
BEGIN

  UPDATE news_photo SET PHOTOURL = nurl where PHOTOURL = url and NEWSID=n_id and AUTHORID=e_id ;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deletenews_photo(url IN news_photo.PHOTOURL%TYPE,
											   n_id IN news_photo.NEWSID%TYPE,
											   e_id IN news_photo.AUTHORID%TYPE)
IS
BEGIN

  DELETE news_photo where PHOTOURL = url and NEWSID=n_id and AUTHORID=e_id ;
  COMMIT;

END;
/
/* end news_photo procedures */

/* activity procedures */
CREATE OR REPLACE PROCEDURE insertactivity(descr IN activity.DESCRIPTION%TYPE)
IS
BEGIN

  INSERT INTO activity ("DESCRIPTION")
  VALUES (descr);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updateactivity(a_id IN activity.ID%TYPE,
										   descr IN activity.DESCRIPTION%TYPE)
IS
BEGIN

  UPDATE activity SET  DESCRIPTION= descr where  ID=a_id ;

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteactivity(a_id IN activity.ID%TYPE)
IS
BEGIN

  DELETE activity where ID = a_id;
  COMMIT;

END;
/
/* end activity procedures */

/*user_activity procedures */
CREATE OR REPLACE PROCEDURE insertuseractivity(u_id IN user_activity.USERID%TYPE,
												ac_id IN user_activity.ACTIVITYTYPE%TYPE,
												a_date IN user_activity.ACDATE%TYPE)
IS
BEGIN

  INSERT INTO user_activity ("USERID","ACTIVITYTYPE","ACDATE")
  VALUES (u_id,ac_id,a_date);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updateuseractivity(u_id IN user_activity.USERID%TYPE,
												ac_id IN user_activity.ACTIVITYTYPE%TYPE,
												a_date IN user_activity.ACDATE%TYPE)
IS
BEGIN
	/* no update datas this table */
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteuseractivity(u_id IN user_activity.USERID%TYPE,
												ac_id IN user_activity.ACTIVITYTYPE%TYPE,
												a_date IN user_activity.ACDATE%TYPE)
IS
BEGIN

  DELETE user_activity where USERID = u_id and ACTIVITYTYPE = ac_id and ACDATE = a_date;
  COMMIT;

END;
/
/* end user_activity procedures */

/*admin_activity procedures */
CREATE OR REPLACE PROCEDURE insertadmin_activity(u_id IN admin_activity.ADMINID%TYPE,
												ac_id IN admin_activity.ACTIVITYTYPE%TYPE,
												a_date IN admin_activity.ACDATE%TYPE)
IS
BEGIN

  INSERT INTO admin_activity ("ADMINID","ACTIVITYTYPE","ACDATE")
  VALUES (u_id,ac_id,a_date);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updateadmin_activity(u_id IN admin_activity.ADMINID%TYPE,
												ac_id IN admin_activity.ACTIVITYTYPE%TYPE,
												a_date IN admin_activity.ACDATE%TYPE)
IS
BEGIN
	/* no update datas this table */
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteadmin_activity(u_id IN admin_activity.ADMINID%TYPE,
												ac_id IN admin_activity.ACTIVITYTYPE%TYPE,
												a_date IN admin_activity.ACDATE%TYPE)
IS
BEGIN

  DELETE admin_activity where ADMINID = u_id and ACTIVITYTYPE = ac_id and ACDATE = a_date;
  COMMIT;

END;
/
/* end admin_activity procedures */

/*admin procedures */
CREATE OR REPLACE PROCEDURE insertadmin(mail IN admin.EMAIL%TYPE,
										pass IN admin.PASSWORD%TYPE)
IS
BEGIN
 
  INSERT INTO ADMIN ("EMAIL","PASSWORD")
  VALUES (mail,pass);

  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE Updateadmin(a_id IN admin.ID%TYPE,
										mail IN admin.EMAIL%TYPE,
										pass IN admin.PASSWORD%TYPE)
IS
BEGIN
	UPDATE admin SET  EMAIL= mail, PASSWORD=pass where  ID=a_id ;
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteadmin(a_id IN admin.ID%TYPE)
IS
BEGIN

  DELETE admin where ID = a_id ;
  COMMIT;

END;
/
/* end admin procedures */

/* person table procedures */
CREATE OR REPLACE PROCEDURE insertperson( p_name IN person.NAME%TYPE,
										   p_surname IN person.SURNAME%TYPE,
										   pass IN person.PASSWORD%TYPE,
										   p_email IN person.EMAIL%TYPE,
										   pertype IN person.PERMISSIONID%TYPE,
										   birth IN person.BIRTHDATE%TYPE,
										   n_pp IN person.pp%TYPE)
IS
BEGIN
	INSERT INTO person ("NAME","SURNAME","PASSWORD","PERMISSIONID","EMAIL","BIRTHDATE",	"PP")
			VALUES (p_name,p_surname,pass,pertype,p_email,TO_DATE(birth,'DD/MM/RRRR'),n_pp);
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE updateperson (p_id IN person.ID%TYPE,
								   p_name IN person.NAME%TYPE,
								   p_surname IN person.SURNAME%TYPE,
								   pass IN person.PASSWORD%TYPE,
                                   n_pp IN person.pp%TYPE)
IS
BEGIN
	UPDATE person SET  NAME= p_name, PASSWORD=pass,SURNAME =p_surname, PP=n_pp where  ID=p_id ;
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteperson (p_id IN person.ID%TYPE)
IS
BEGIN

  DELETE person where ID = p_id ;
  COMMIT;

END;
/
/* end person procedures */

/* author table procedures */
CREATE OR REPLACE PROCEDURE insertauthor(p_id IN author.PERSONID%TYPE,
										 signatur IN author.SIGNATURE%TYPE)
IS
BEGIN
	INSERT INTO author ("PERSONID","SIGNATURE")
			VALUES (p_id,signatur);
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE updateauthor (p_id IN author.PERSONID%TYPE,
										  signatur IN author.SIGNATURE%TYPE)
IS
BEGIN
	UPDATE author SET  SIGNATURE= signatur where  PERSONID=p_id ;
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteauthor (p_id IN author.PERSONID%TYPE)
IS
BEGIN

  DELETE author where PERSONID = p_id ;
  COMMIT;

END;
/
/* end author procedures */

/* user_ table procedures */
CREATE OR REPLACE PROCEDURE insertuser(p_id IN user_.PERSONID%TYPE,
									   p_username IN user_.USERNAME%TYPE,
									   p_gender IN user_.GENDER%TYPE)
IS
BEGIN
	INSERT INTO user_ ("PERSONID","USERNAME","GENDER")
			VALUES (p_id,p_username,p_gender);
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE updateuser (p_id IN user_.PERSONID%TYPE,
									   p_username IN user_.USERNAME%TYPE)
IS
BEGIN
	UPDATE user_ SET  USERNAME= p_username where  PERSONID=p_id ;
  COMMIT;

END;
/

CREATE OR REPLACE PROCEDURE deleteuser (p_id IN user_.PERSONID%TYPE)
IS
BEGIN

  DELETE user_ where PERSONID = p_id ;
  COMMIT;

END;
/
/* end USER procedures */


