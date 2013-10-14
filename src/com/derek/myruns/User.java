package com.derek.myruns;

public class User {
	String userName_, teamName_;
	long uid_, teamID_;
	int unit_;	// O = mi, 1 = km
	
	// Default constructor
	User() {
		userName_ = null;
		teamName_ = null;
		uid_ = 0;
		teamID_ = 0;
		unit_ = 0;
	}
	
	// Better constructor
	User( String uName, String tName, long id, long tID, int unit) {
		userName_ = uName;
		teamName_ = tName;
		uid_ = id;
		teamID_ = tID;
		unit_ = unit;
	}
	
	// From string constructor
	// NOTE: The string must follow the format generated by the toString() method!
	User (String fromString) {
		String myArray[] = null;
		myArray = fromString.split("/");
		userName_ = myArray[0];
		teamName_ = myArray[1];
		uid_ = Long.parseLong(myArray[2]);
		teamID_ = Long.parseLong(myArray[3]);
		unit_ = Integer.parseInt(myArray[4]);
	}
	
	// Set functions
	protected void setUserName(String newName) {
		if (!newName.matches("")) {
			userName_ = newName;
		}
	}
	protected void setTeamName(String newTeamName) {
		if (!newTeamName.matches("")) {
			teamName_ = newTeamName;
		}
	}
	protected void setUID(long newID) {
		if (newID > 0) {
			uid_ = newID;
		}
	}
	protected void setTeamID(long newTeamID) {
		if (newTeamID >= 0) {
			teamID_ = newTeamID;
		}
	}
	protected void setUnit(int newUnit) {
		if (newUnit >= 0 && newUnit < 2) {
			unit_ = newUnit;
		}
	}
	
	// Get functions
	protected String getUserName() {
		return userName_;
	}
	protected String getTeamName() {
		return teamName_;
	}
	protected long getUID() {
		return uid_;
	}
	protected long getTeamID() {
		return teamID_;
	}
	protected int getUnit() {
		return unit_;
	}

	// To String
	public String toString() {
		String myVal = null;
		
		myVal = userName_ + "/";
		myVal += teamName_ + "/";
		myVal += String.valueOf(uid_) + "/";
		myVal += String.valueOf(teamID_) + "/";
		myVal += String.valueOf(unit_);
		
		return myVal;
	}
	
}