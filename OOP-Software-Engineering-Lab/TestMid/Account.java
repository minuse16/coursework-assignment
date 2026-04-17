import java.util.Scanner;

public class Account extends Person implements ATMAction {
    static Manager manager;
    String password;
    double balance;
    double btcTothbRate;
    Scanner scanner = new Scanner(System.in);

    Account(String idNumber, String fullName, String gender, String password, double balance) {
        super(idNumber, fullName, gender);
        if (password.length() != 4) {
            throw new IllegalArgumentException("Password must have 4 digits.");
        }
        if (balance < 0) {
            throw new IllegalArgumentException("Balance cannot be negative.");
        }
        this.password = password;
        this.balance = balance;
        this.btcTothbRate = 0;
    }

    boolean validatePassword(String password) {
        return this.password.equals(password);
    }

    double getBalance() {
        return balance;
    }

    @Override
    public void checkBalance() {
        System.out.println("Your current balance is : " + balance + " THB");
    }

    @Override
    public void withdrawMoney() {
        System.out.print("Enter amount to withdraw (THB) : ");
        double amount = scanner.nextDouble();

        if (amount <= 0) {
            System.out.println("Withdrawal amount must be greater than zero.");
        } else if (amount > balance) {
            System.out.println("Insufficient balance.");
        } else {
            balance -= amount;
            System.out.println("Withdrawal successful. Remaining balance : " + balance);
        }
    }

    void withdrawInBTC(double rate) {
        if (rate <= 0) {
            System.out.println("BTC to THB rate is not set or invalid.");
            return;
        }
    
        System.out.print("Enter amount to withdraw (BTC) : ");
        double btcAmount = scanner.nextDouble();
    
        double thbAmount = btcAmount * rate;
    
        if (btcAmount <= 0) {
            System.out.println("Withdrawal amount must be greater than zero.");
        } else if (thbAmount > balance) {
            System.out.println("Insufficient balance.");
        } else {
            balance -= thbAmount;
            System.out.println("Withdrawal successful. Remaining balance : " + balance);
        }
    }

    @Override
    public void depositMoney() {
        System.out.print("Enter amount to deposit (THB) : ");
        double amount = scanner.nextDouble();

        if (amount <= 0) {
            System.out.println("Deposit amount must be greater than zero.");
        } else {
            balance += amount;
            System.out.println("Deposit successful.");
        System.out.println("Deposited : " + amount + " THB");
        System.out.println("New balance : " + balance);
        }
    }

    void depositInBTC(double rate) {
        System.out.print("Enter amount to deposit (BTC) : ");
        double btcAmount = scanner.nextDouble();

        if (btcAmount <= 0) {
            System.out.println("Amount must be greater than 0.");
        }
        double thbAmount = btcAmount * rate;
        balance += thbAmount;
        System.out.println("Deposit successful.");
        System.out.println("Deposited : " + thbAmount + " THB");
        System.out.println("New balance : " + balance);
    }

    @Override
    public void transferMoney() {
        System.out.print("Enter recipient ID : ");
        String recipientId = scanner.nextLine();
        scanner.nextLine();

        System.out.print("Enter amount to transfer : ");
        while (!scanner.hasNextDouble()) {
            System.out.println("Invalid amount. Please enter a numeric value.");
            System.out.print("Enter amount to transfer : ");
            scanner.next();
        }
        double amount = scanner.nextDouble();
        scanner.nextLine();

        if (amount <= 0) {
            System.out.println("Transfer amount must be greater than zero.");
            return;
        }
        if (amount > balance) {
            System.out.println("Insufficient balance.");
            return;
        }

        Account recipient = ATM.findAccountById(recipientId);
        if (recipient == null) {
            System.out.println("Recipient account not found.");
            return;
        }

        balance -= amount;
        recipient.receiveMoney(amount); // ใช้เมธอดที่เพิ่มเงินโดยตรง
        System.out.println("Transfer successful. Remaining balance : " + balance);
    }

    void receiveMoney(double amount) {
        if (amount > 0) {
            balance += amount;
        }
    }

    @Override
    public String toString() {
        return "Account{" +
                "idNumber='" + getIdNumber() + '\'' +
                ", fullName='" + getFullName() + '\'' +
                ", gender='" + getGender() + '\'' +
                ", balance=" + balance +
                '}';
    }
}
